import * as pulumi from "@pulumi/pulumi";
import * as awsx from "@pulumi/awsx";
import * as eks from "@pulumi/eks";
import * as k8s from "@pulumi/kubernetes";
import * as random from "@pulumi/random";
import * as aws from "@pulumi/aws";

// #############################################################################
// PASO 1: INFRAESTRUCTURA DE AWS (EKS y ECR)
// #############################################################################

// 1.1. Crear un repositorio ECR para guardar la imagen de la app
const repo = new awsx.ecr.Repository("laravel-repo");

// 1.2. Construir y publicar la imagen de Docker de Laravel
// (Ajusta 'dockerfile:' a la ruta correcta de tu Dockerfile)
const appImage = new awsx.ecr.Image("laravel-app-image", {
    repositoryUrl: repo.url,
    dockerfile: "../docker/fpm.Dockerfile", // Usar el Dockerfile que existe
    context: "../", // Contexto desde la raíz del proyecto
});

// 1.3. Crear VPC con zonas de disponibilidad correctas (evitar us-east-1e)
const vpc = new awsx.ec2.Vpc("laravel-vpc", {
    cidrBlock: "10.0.0.0/16",
    availabilityZoneNames: ["us-east-1a", "us-east-1b"], // Zonas soportadas por EKS
    natGateways: {
        strategy: "Single", // Más barato: un solo NAT Gateway
    },
});

// 1.4. Crear el Cluster de EKS
const cluster = new eks.Cluster("laravel-cluster", {
    instanceType: "t3.small", // Más pequeño y barato
    desiredCapacity: 1, // Solo 1 nodo para reducir costos
    minSize: 1,
    maxSize: 2,
    vpcId: vpc.vpcId,
    publicSubnetIds: vpc.publicSubnetIds,
    privateSubnetIds: vpc.privateSubnetIds,
    // Configuración adicional para evitar problemas de autenticación
    createOidcProvider: true,
    enabledClusterLogTypes: ["api", "audit", "authenticator"],
});

// Exportamos la URL de la imagen y el Kubeconfig
export const imageUrl = appImage.imageUri;
export const kubeconfig = cluster.kubeconfig;

// #############################################################################
// PASO 2: PROVIDER DE KUBERNETES
// #############################################################################

// 2.1. Crear un "provider" de K8s que usa el Kubeconfig de nuestro cluster EKS.
// Le dice a Pulumi dónde desplegar los siguientes recursos.
const k8sProvider = new k8s.Provider("k8s-provider", {
    kubeconfig: cluster.kubeconfig.apply(JSON.stringify),
});

// #############################################################################
// PASO 3: DEPENDENCIAS (MySQL y Redis desde tus YAMLs)
// #############################################################################
// Usamos 'k8s.yaml.ConfigFile' para aplicar tus YAMLs existentes.

// 3.1. Desplegar MySQL
// (Nota: Para producción real, usarías AWS RDS)
const mysql = new k8s.yaml.ConfigFile(
    "mysql",
    {
        file: "../k8s/mysql.yaml",
    },
    { provider: k8sProvider }
);

// 3.2. Desplegar Redis
// (Nota: Para producción real, usarías AWS ElastiCache)
const redis = new k8s.yaml.ConfigFile(
    "redis",
    {
        file: "../k8s/redis.yaml",
    },
    { provider: k8sProvider }
);

// #############################################################################
// PASO 4: CONFIGURACIÓN Y SECRETOS (La forma Pulumi)
// #############################################################################

// 4.1. Desplegar tu ConfigMap (variables de entorno no secretas)
const configMap = new k8s.yaml.ConfigFile(
    "app-config",
    {
        file: "../k8s/app_config.yaml",
    },
    { provider: k8sProvider }
);

// 4.2. Crear el Secreto de forma segura (REEMPLAZA tu 'app_secret.yaml')
// Generamos una APP_KEY aleatoria
const appKey = new random.RandomString("app-key", {
    length: 32,
    special: false,
}).result.apply((key) => `base64:${key}`); // Laravel espera este formato

const appSecret = new k8s.core.v1.Secret(
    "app-secret",
    {
        metadata: {
            name: "laravel-secret", // Dale el nombre que tu app espere
        },
        // 'stringData' es más fácil que 'data' porque no requiere Base64 manual
        stringData: {
            // --- Variables de Laravel ---
            APP_KEY: appKey,

            // --- Conexión a la Base de Datos ---
            // Estos nombres (mysql-service, redis-service) deben coincidir
            // con los nombres de los 'Service' en tus mysql.yaml y redis.yaml
            DB_HOST: "mysql-service",
            DB_DATABASE: "laravel_db", // Ajusta
            DB_USERNAME: "laravel_user", // Ajusta
            DB_PASSWORD: "tu-password-seguro", // ¡Mejor usar Pulumi.Config!

            // --- Conexión a Redis ---
            REDIS_HOST: "redis-service",
            REDIS_PORT: "6379",
        },
    },
    { provider: k8sProvider }
);

// #############################################################################
// PASO 5: DESPLIEGUE DE LA APP (REEMPLAZA tu 'app_deployment.yaml')
// #############################################################################

// 5.1. Crear el Deployment de Laravel nativamente en Pulumi
const appDeployment = new k8s.apps.v1.Deployment(
    "laravel-deployment",
    {
        metadata: {
            name: "laravel-app", // El nombre de tu deployment
        },
        spec: {
            replicas: 2, // Cuántos pods de tu app quieres
            selector: {
                matchLabels: { app: "laravel-app" }, // Debe coincidir con 'template.metadata.labels'
            },
            template: {
                // La plantilla para los Pods
                metadata: {
                    labels: { app: "laravel-app" },
                },
                spec: {
                    containers: [
                        {
                            name: "laravel-container",
                            // ¡AQUÍ ESTÁ LA MAGIA!
                            // Usamos la imagen que construimos en el Paso 1
                            image: appImage.imageUri,
                            ports: [{ containerPort: 9000 }], // Puerto de PHP-FPM o lo que use tu app

                            // ¡AQUÍ CONECTAMOS TODO!
                            // Cargamos todas las variables de entorno desde...
                            envFrom: [
                                // 1. El ConfigMap que creamos
                                {
                                    configMapRef: {
                                        name: configMap.getResource(
                                            "v1/ConfigMap",
                                            "laravel-config"
                                        ).metadata.name,
                                    },
                                },
                                // 2. El Secreto que creamos
                                {
                                    secretRef: {
                                        name: appSecret.metadata.name,
                                    },
                                },
                            ],
                        },
                    ],
                },
            },
        },
    },
    {
        provider: k8sProvider,
        // Nos aseguramos de que la BD y la config estén listas ANTES de iniciar la app
        dependsOn: [mysql, redis, configMap, appSecret],
    }
);

// #############################################################################
// PASO 6: EXPONER LA APP (Servicio)
// #############################################################################

// 6.1. Desplegamos tu 'app_service.yaml' para crear el LoadBalancer
const appService = new k8s.yaml.ConfigFile(
    "app-service",
    {
        file: "../k8s/app_service.yaml",
    },
    { provider: k8sProvider, dependsOn: [appDeployment] }
);

// 6.2. Exportar la IP o Hostname del LoadBalancer
export const frontendUrl = pulumi
    .output(
        appService.getResource(
            "v1/Service",
            "laravel-service" // Ajusta al nombre correcto en tu YAML
        )
    )
    .apply((svc: any) => {
        // Verificamos que el status exista antes de acceder
        if (
            !svc ||
            !svc.status ||
            !svc.status.loadBalancer ||
            !svc.status.loadBalancer.ingress
        ) {
            return "LoadBalancer endpoint pending...";
        }

        const ingress = svc.status.loadBalancer.ingress[0];
        return ingress.hostname || ingress.ip || "pending";
    });

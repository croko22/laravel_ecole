import * as pulumi from "@pulumi/pulumi";
import * as awsx from "@pulumi/awsx";
import * as eks from "@pulumi/eks";
import * as k8s from "@pulumi/kubernetes";
import * as random from "@pulumi/random";
import * as aws from "@pulumi/aws";

const repo = new awsx.ecr.Repository("laravel-repo");

const appImage = new awsx.ecr.Image("laravel-app-image", {
    repositoryUrl: repo.url,
    dockerfile: "../docker/fpm.Dockerfile",
    context: "../",
});

const vpc = new awsx.ec2.Vpc("laravel-vpc", {
    cidrBlock: "10.0.0.0/16",
    availabilityZoneNames: ["us-east-1a", "us-east-1b"],
    natGateways: {
        strategy: "Single",
    },
});

const cluster = new eks.Cluster("laravel-cluster", {
    instanceType: "t3.small",
    desiredCapacity: 1,
    minSize: 1,
    maxSize: 2,
    vpcId: vpc.vpcId,
    publicSubnetIds: vpc.publicSubnetIds,
    privateSubnetIds: vpc.privateSubnetIds,

    createOidcProvider: true,
    enabledClusterLogTypes: ["api", "audit", "authenticator"],
});

export const imageUrl = appImage.imageUri;
export const kubeconfig = cluster.kubeconfig;

const k8sProvider = new k8s.Provider("k8s-provider", {
    kubeconfig: cluster.kubeconfig.apply(JSON.stringify),
});

const mysql = new k8s.yaml.ConfigFile(
    "mysql",
    {
        file: "../k8s/mysql.yaml",
    },
    { provider: k8sProvider }
);

const redis = new k8s.yaml.ConfigFile(
    "redis",
    {
        file: "../k8s/redis.yaml",
    },
    { provider: k8sProvider }
);

const configMap = new k8s.yaml.ConfigFile(
    "app-config",
    {
        file: "../k8s/app_config.yaml",
    },
    { provider: k8sProvider }
);

const appSecret = new k8s.core.v1.Secret(
    "app-secret",
    {
        metadata: {
            name: "laravel-secret",
        },

        stringData: {
            DB_HOST: "mysql",
            DB_DATABASE: "application",
            DB_USERNAME: "root",
            DB_PASSWORD: "rootpass",

            REDIS_HOST: "redis",
            REDIS_PORT: "6379",
        },
    },
    { provider: k8sProvider }
);

const nginxConfig = new k8s.core.v1.ConfigMap(
    "nginx-config",
    {
        metadata: {
            name: "nginx-config",
        },
        data: {
            "default.conf": `
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \\.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\\.ht {
        deny all;
    }
}
            `,
        },
    },
    { provider: k8sProvider }
);

const appDeployment = new k8s.apps.v1.Deployment(
    "laravel-deployment",
    {
        metadata: {
            name: "laravel-app",
        },
        spec: {
            replicas: 2,
            selector: {
                matchLabels: { app: "laravel-app" },
            },
            template: {
                metadata: {
                    labels: { app: "laravel-app" },
                },
                spec: {
                    initContainers: [
                        {
                            name: "copy-app",
                            image: appImage.imageUri,
                            command: [
                                "sh",
                                "-c",
                                "cp -r /var/www/html/. /app-files/ && cp /var/www/html/.env.example /app-files/.env && cd /app-files && php artisan key:generate --force",
                            ],
                            envFrom: [
                                {
                                    configMapRef: {
                                        name: "application-config",
                                    },
                                },
                                {
                                    secretRef: {
                                        name: appSecret.metadata.name,
                                    },
                                },
                            ],
                            volumeMounts: [
                                {
                                    name: "app-files",
                                    mountPath: "/app-files",
                                },
                            ],
                        },
                    ],
                    containers: [
                        {
                            name: "php-fpm",
                            image: appImage.imageUri,
                            ports: [{ containerPort: 9000 }],
                            envFrom: [
                                {
                                    configMapRef: {
                                        name: "application-config",
                                    },
                                },
                                {
                                    secretRef: {
                                        name: appSecret.metadata.name,
                                    },
                                },
                            ],
                            volumeMounts: [
                                {
                                    name: "app-files",
                                    mountPath: "/var/www/html",
                                },
                            ],
                        },
                        {
                            name: "nginx",
                            image: "nginx:1.25-alpine",
                            ports: [{ containerPort: 80 }],
                            volumeMounts: [
                                {
                                    name: "app-files",
                                    mountPath: "/var/www/html",
                                },
                                {
                                    name: "nginx-config",
                                    mountPath: "/etc/nginx/conf.d/default.conf",
                                    subPath: "default.conf",
                                },
                            ],
                        },
                    ],
                    volumes: [
                        {
                            name: "app-files",
                            emptyDir: {},
                        },
                        {
                            name: "nginx-config",
                            configMap: {
                                name: "nginx-config",
                            },
                        },
                    ],
                },
            },
        },
    },
    {
        provider: k8sProvider,

        dependsOn: [mysql, redis, configMap, appSecret, nginxConfig],
    }
);

const appService = new k8s.yaml.ConfigFile(
    "app-service",
    {
        file: "../k8s/app_service.yaml",
    },
    { provider: k8sProvider, dependsOn: [appDeployment] }
);

export const frontendUrl = pulumi
    .output(appService.getResource("v1/Service", "laravel-service"))
    .apply((svc: any) => {
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

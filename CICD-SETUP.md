# 🚀 CI/CD Setup - Laravel EKS Deployment

Este proyecto usa **GitHub Actions** para automatizar el despliegue a AWS EKS con Pulumi.

## 📋 Requisitos Previos

1. Cuenta de GitHub con el repositorio: `croko22/laravel_ecole`
2. Cuenta de AWS con credenciales de acceso
3. Cuenta de Pulumi (para el state management)

## 🔑 Paso 1: Configurar GitHub Secrets

Debes agregar 3 secretos a tu repositorio de GitHub:

### Ir a la configuración de secretos:
```
https://github.com/croko22/laravel_ecole/settings/secrets/actions
```

### Agregar estos secretos:

#### 1. `AWS_ACCESS_KEY_ID`
- Tu AWS Access Key ID
- Ejemplo: `AKIAIOSFODNN7EXAMPLE`
- Para obtenerlo:
  ```bash
  aws configure get aws_access_key_id
  ```

#### 2. `AWS_SECRET_ACCESS_KEY`
- Tu AWS Secret Access Key
- ⚠️ **NUNCA** lo compartas públicamente
- Para obtenerlo:
  ```bash
  aws configure get aws_secret_access_key
  ```

#### 3. `PULUMI_ACCESS_TOKEN`
- Token de acceso a Pulumi
- Obtenerlo en: https://app.pulumi.com/account/tokens
- O crear uno nuevo:
  ```bash
  pulumi login
  # Seguir las instrucciones para crear un token
  ```

## 🔄 Paso 2: Cómo Funciona el CI/CD

El workflow se ejecuta automáticamente en estos casos:

### Trigger Automático
Cada vez que haces `git push` a la rama `main`:
```bash
git add .
git commit -m "feat: nueva funcionalidad"
git push origin main
```

### Trigger Manual
También puedes ejecutarlo manualmente:
1. Ve a: https://github.com/croko22/laravel_ecole/actions
2. Selecciona el workflow: **🚀 Deploy Laravel App to AWS EKS**
3. Click en **Run workflow**

## 📊 Proceso del Pipeline

### Job 1: 🧪 Test (CI)
```
1. Checkout del código
2. Setup PHP 8.2
3. Instalar dependencias (composer)
4. Copiar .env.example → .env
5. Generar APP_KEY
6. Ejecutar tests (php artisan test)
```

### Job 2: 🚀 Deploy (CD)
Solo se ejecuta si los tests pasan:
```
1. Checkout del código
2. Setup Node.js 18
3. Configurar credenciales de AWS
4. Instalar dependencias de Pulumi (npm install)
5. Ejecutar Pulumi Up (desplegar infraestructura)
6. Mostrar URL de la aplicación
```

## 📝 Ejemplo de Uso

### 1. Agregar los secretos en GitHub
```bash
# Ejecutar el script helper para ver la info
./setup-github-secrets.sh
```

### 2. Hacer cambios en tu código
```bash
# Editar algún archivo
vim resources/views/welcome.blade.php

# Agregar cambios
git add .
git commit -m "Update welcome page"
```

### 3. Push a main (dispara el CI/CD)
```bash
git push origin main
```

### 4. Monitorear el despliegue
Ve a GitHub Actions:
```
https://github.com/croko22/laravel_ecole/actions
```

Verás algo como:
```
✅ Test Laravel App (2m 15s)
  ✅ Checkout repository
  ✅ Setup PHP
  ✅ Install Composer dependencies
  ✅ Run tests

✅ Deploy to AWS EKS with Pulumi (3m 45s)
  ✅ Checkout repository
  ✅ Setup Node.js
  ✅ Configure AWS credentials
  ✅ Install Pulumi dependencies
  ✅ Pulumi Up (Deploy Infrastructure)
  ✅ Get deployment URL
```

## 🐛 Troubleshooting

### Error: "AWS credentials not found"
- Verifica que agregaste `AWS_ACCESS_KEY_ID` y `AWS_SECRET_ACCESS_KEY` en GitHub Secrets
- Asegúrate de no tener espacios extra al copiar/pegar

### Error: "Pulumi login failed"
- Verifica que `PULUMI_ACCESS_TOKEN` esté correctamente configurado
- Crea un nuevo token en: https://app.pulumi.com/account/tokens

### Error: "Tests failed"
- El job de Deploy NO se ejecutará si los tests fallan
- Revisa los logs del job "Test Laravel App"
- Arregla los tests y vuelve a hacer push

### Error: "Docker build failed"
- Verifica que el Dockerfile esté correcto
- Asegúrate que `package.json` existe en el root del proyecto

## 🎯 Workflow Completo

```mermaid
graph TD
    A[Push to main] --> B[Trigger GitHub Actions]
    B --> C{Run Tests}
    C -->|Pass| D[Deploy with Pulumi]
    C -->|Fail| E[❌ Stop - Fix tests]
    D --> F[Build Docker Image]
    F --> G[Push to ECR]
    G --> H[Update EKS Deployment]
    H --> I[✅ Deployment Complete]
    I --> J[Show Application URL]
```

## 💰 Costos

**⚠️ IMPORTANTE**: GitHub Actions es gratis para repos públicos, pero AWS cobra por:
- EKS Cluster (~$73/mes solo por el control plane)
- EC2 instances (t3.small ~$15/mes)
- LoadBalancer (~$16/mes)
- Data transfer

**Para ahorrar costos después de la demo:**
```bash
# Destruir toda la infraestructura
cd infra
pulumi destroy --yes
```

## 📚 Recursos Adicionales

- [GitHub Actions Docs](https://docs.github.com/en/actions)
- [Pulumi GitHub Actions](https://www.pulumi.com/docs/using-pulumi/continuous-delivery/github-actions/)
- [AWS EKS Best Practices](https://aws.github.io/aws-eks-best-practices/)

## 🆘 Soporte

Si tienes problemas:
1. Revisa los logs en GitHub Actions
2. Verifica que todos los secretos estén configurados
3. Asegúrate de tener permisos suficientes en AWS

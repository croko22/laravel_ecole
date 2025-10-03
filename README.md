# Laravel ecole

This project demonstrates a school management system using Laravel with Livewire for real-time interactions. The system includes functionalities for managing courses, students, users, and attendance.

## Prerequisites

- Node.js
- Composer
- PHP
- Laravel
- MySQL or any other database supported by Laravel

## Functionalities

- **Dashboard**: 
  - **Cursos**: Manage courses.
  - **Estudiantes**: Manage students.
  - **Usuarios**: Manage users.
  - **Profesores**: Manage teachers.
  - **Administradores**: Manage administrators.
- **Tablas**:
  - **Nombre, Apellido, Datos, paginacion, busqueda**: Manage tables with pagination and search.
  - **Crear, editar, borrar**: Create, edit, and delete records.
- **Asistencia**:
  - **Profesor, puede tomar la asistencia de los alumnos**: Teachers can take attendance.
  - **Profesores están asignados a una clase**: Teachers are assigned to a class.
  - **Profesores no pueden agregar estudiantes, cursos o administrados ||| tomar asistencia**: Teachers cannot add students, courses, or administrators but can take attendance.
- **Rich text Tiny**: Description with rich text editor.

## Installation

```sh
git clone https://github.com/croko22/laravel_ecole
cd laravel_ecole
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
npm run dev
```

## Usage

1. Open your browser and navigate to `http://localhost:8000`.
2. You should see the login page. Enter your credentials to log in.
3. Upon successful login, you will be redirected to the dashboard.


# Kubernetes
Guía para configurar y desplegar una aplicación Laravel en un clúster de Kubernetes local.

### **1. Crear el clúster**

Crea un clúster local con `kind`.

```bash
kind create cluster --name laravel-ecole
```

### **2. Construir las imágenes Docker**

Construye las imágenes para el frontend (Nginx) y el backend (PHP-FPM).

```bash
# Construir imagen del frontend
docker build -t frontend:latest -f docker/nginx.Dockerfile .

# Construir imagen del backend
docker build -t backend:latest -f docker/fpm.Dockerfile .
```

### **3. Cargar las imágenes en el clúster**

El clúster de `kind` no tiene acceso a las imágenes locales, por lo que deben cargarse manualmente.

```bash
# Cargar imagen del frontend
kind load docker-image frontend:latest --name laravel-ecole

# Cargar imagen del backend
kind load docker-image backend:latest --name laravel-ecole
```

### **4. Instalar la base de datos (MySQL)**

Instala MySQL usando Helm. Este paso debe ejecutarse antes de desplegar la aplicación para asegurar que la base de datos esté disponible.

```bash
# Añadir repositorio de Bitnami (solo si no lo tienes)
helm repo add bitnami https://charts.bitnami.com/bitnami
helm repo update

# Instalar MySQL
helm install mysql bitnami/mysql \
  --set auth.database="application" \
  --set auth.username="appuser" \
  --set auth.password="sqlhardPass123"
```


### **5. Desplegar la aplicación**

Aplica los manifiestos de Kubernetes. Puedes aplicar todos los archivos de un directorio de una vez.

```bash
# Aplicar todos los manifiestos del directorio k8s/
kubectl apply -f k8s/
```

O de forma individual:

```bash
kubectl apply -f k8s/app_config.yaml
kubectl apply -f k8s/app_secret.yaml
kubectl apply -f k8s/app_deployment.yaml
kubectl apply -f k8s/app_service.yaml
```


### **6. Acceder a la aplicación**

1.  **Obtén la información del servicio** para encontrar el puerto de acceso (`NodePort`).

    ```bash
    kubectl get svc web-application-svc
    ```

2.  **Identifica el `NodePort`**. En la salida, busca el número de puerto mapeado al puerto 80. Por ejemplo, `80:30080/TCP` indica que el `NodePort` es `30080`.

    ```
    NAME                  TYPE       CLUSTER-IP      EXTERNAL-IP   PORT(S)        AGE
    web-application-svc   NodePort   10.96.162.227   <none>        80:30080/TCP   5m
    ```

3.  **Abre la aplicación** en `http://localhost:[NodePort]`. Con el ejemplo anterior, sería `http://localhost:30080`.


### **7. Limpieza**

Para eliminar el clúster y liberar recursos, ejecuta:

```bash
kind delete cluster --name laravel-ecole
```

# License

This project is open-source and available under the MIT License.
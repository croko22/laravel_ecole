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

## License

This project is open-source and available under the MIT License.
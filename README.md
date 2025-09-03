
# To-Do App Laravel

Aplicación web de gestión de tareas diarias personales desarrollada con Laravel 12, MySQL y Breeze.

## Características

- **CRUD completo de tareas**: Crear, ver, editar, eliminar y restaurar tareas.
- **Autenticación de usuarios**: Registro, login, perfil y protección de rutas.
- **Relación User -> Tasks**: Cada usuario gestiona sus propias tareas.
- **Filtros por estado**: Pendiente, completada, eliminada (soft delete).
- **Soft deletes y recuperación**: Elimina tareas sin perder datos y permite restaurarlas.
- **Interfaz moderna y responsiva**: Diseño profesional con Tailwind CSS, modo oscuro y animaciones.
- **Base de datos MySQL**: Compatible con phpMyAdmin.

## Requisitos

- PHP >= 8.2
- Node.js >= 20.19 o >= 22.12
- Composer
- MySQL

## Instalación

1. Clona el repositorio o copia los archivos en tu entorno local.
2. Instala dependencias:
	```bash
	composer install
	npm install
	```
3. Configura el archivo `.env` con tus credenciales de MySQL:
	```env
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=todo_app
	DB_USERNAME=root
	DB_PASSWORD=
	```
4. Ejecuta las migraciones y seeders:
	```bash
	php artisan migrate --seed
	```
5. Compila los assets:
	```bash
	npm run build
	```
6. Inicia el servidor:
	```bash
	php artisan serve
	```

## Usuario de prueba

- **Email:** test@example.com
- **Password:** password

## Uso

- Accede a [http://127.0.0.1:8000](http://127.0.0.1:8000)
- Inicia sesión y gestiona tus tareas
- Filtra por estado, edita, elimina y restaura tareas

## Estructura principal

- `app/Models/Task.php`: Modelo de tareas
- `app/Http/Controllers/TaskController.php`: Lógica de tareas
- `app/Policies/TaskPolicy.php`: Autorización
- `resources/views/tasks/`: Vistas Blade para tareas
- `routes/web.php`: Rutas principales
- `database/migrations/`: Migraciones
- `database/seeders/`: Seeders de prueba
- `resources/css/app.css`: Estilos personalizados
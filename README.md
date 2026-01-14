<h1>📋 Sistema de Gestión de Tareas </h1>

Sistema CRUD completo para gestionar tareas desarrollado con Laravel.

## 🚀 Características

- ✅ Crear tareas
- ✏️ Editar tareas
- 🗑️ Eliminar tareas
- 📊 Ver lista de tareas
- 🎨 Estados: Pendiente, En Progreso, Completada
- ✔️ Validaciones de formularios

## 🛠️ Tecnologías Utilizadas

- PHP 8.x
- Laravel 10/11
- MySQL
- Blade Templates
- HTML/CSS

## 📦 Instalación

1. Clona el repositorio:
```bash
git clone https://github.com/tu-usuario/task-management-laravel.git
cd task-management-laravel
```

2. Instala las dependencias:
```bash
composer install
```

3. Copia el archivo de configuración:
```bash
cp .env.example .env
```

4. Genera la key de la aplicación:
```bash
php artisan key:generate
```

5. Configura tu base de datos en el archivo `.env`:
```env
DB_DATABASE=task_app
DB_USERNAME=root
DB_PASSWORD=
```

6. Ejecuta las migraciones:
```bash
php artisan migrate
```

7. Inicia el servidor:
```bash
php artisan serve
```

8. Abre tu navegador en: `http://localhost:8000/tasks`

## 📸 Screenshots

<img width="1121" height="556" alt="image" src="https://github.com/user-attachments/assets/70de3082-1715-4f12-81ca-3f96fe6327d9" />


## 👨‍💻 Autor

Johan Piedra - [GitHub de Johan](https://github.com/jpiedradev)

## 📄 Licencia

Este proyecto es de código abierto.

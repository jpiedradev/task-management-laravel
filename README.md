# 📋 Sistema de Gestión de Tareas

Sistema CRUD completo para gestionar tareas desarrollado con Laravel. Cada usuario puede crear, editar y eliminar sus propias tareas con un sistema de autenticación robusto.

## ✨ Características Principales

### 🔐 Autenticación
- ✅ Registro de usuarios
- ✅ Inicio de sesión
- ✅ Cierre de sesión
- ✅ Protección de rutas con middleware
- ✅ Cada usuario solo ve y gestiona sus propias tareas

### 📝 Gestión de Tareas
- ✅ Crear tareas
- ✏️ Editar tareas
- 🗑️ Eliminar tareas
- 📊 Ver lista de tareas
- 🎨 Estados: Pendiente, En Progreso, Completada
- ✔️ Validaciones de formularios
- 🔒 Validación de permisos (solo el dueño puede editar/eliminar)

### 🔍 Búsqueda y Filtros
- 🔎 Búsqueda por título
- 📊 Filtro por estado
- 🔽 Ordenamiento múltiple:
  - Más recientes
  - Más antiguos
  - Alfabético (A-Z)
  - Alfabético (Z-A)
- 🧹 Botón para limpiar filtros

### 📈 Dashboard y Estadísticas
- 📊 Total de tareas
- ⏳ Tareas pendientes
- 🔄 Tareas en progreso
- ✅ Tareas completadas
- 🎨 Tarjetas visuales con gradientes

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 8.x
- **Framework:** Laravel 11
- **Base de datos:** MySQL
- **Autenticación:** Laravel Breeze
- **Frontend:** Blade Templates
- **Estilos:** HTML/CSS
- **Control de versiones:** Git

## 📦 Instalación

### Requisitos previos
- PHP >= 8.1
- Composer
- MySQL
- Node.js y NPM

### Pasos de instalación

1. **Clona el repositorio:**
```bash
git clone https://github.com/jpiedradev/task-management-laravel.git
cd task-management-laravel
```

2. **Instala las dependencias de PHP:**
```bash
composer install
```

3. **Instala las dependencias de Node:**
```bash
npm install
```

4. **Copia el archivo de configuración:**
```bash
cp .env.example .env
```

5. **Genera la key de la aplicación:**
```bash
php artisan key:generate
```

6. **Configura tu base de datos en el archivo `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_app
DB_USERNAME=root
DB_PASSWORD=
```

7. **Crea la base de datos:**
- Abre phpMyAdmin o tu cliente MySQL
- Crea una base de datos llamada `task_app`

8. **Ejecuta las migraciones:**
```bash
php artisan migrate
```

9. **Compila los assets:**
```bash
npm run dev
```

10. **Inicia el servidor:**
```bash
php artisan serve
```

11. **Abre tu navegador en:** `http://localhost:8000`

## 🎮 Uso

### Primeros pasos

1. **Regístrate** en la aplicación
2. **Inicia sesión** con tus credenciales
3. **Crea tu primera tarea**
4. **Gestiona tus tareas** (editar, eliminar, cambiar estado)
5. **Usa los filtros** para organizar tus tareas

### Estructura de la aplicación
```
/login          → Iniciar sesión
/register       → Registrarse
/tasks          → Lista de tareas (requiere autenticación)
/tasks/create   → Crear nueva tarea
/tasks/{id}/edit → Editar tarea
```

## 🗂️ Estructura del Proyecto
```
task-api/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/              # Controladores de autenticación
│   │       └── TaskController.php # Controlador de tareas
│   └── Models/
│       ├── User.php               # Modelo de usuario
│       └── Task.php               # Modelo de tarea
├── database/
│   └── migrations/                # Migraciones de base de datos
├── resources/
│   └── views/
│       ├── auth/                  # Vistas de autenticación
│       └── tasks/                 # Vistas de tareas
│           ├── index.blade.php    # Lista de tareas
│           ├── create.blade.php   # Crear tarea
│           └── edit.blade.php     # Editar tarea
└── routes/
    ├── web.php                    # Rutas web
    └── auth.php                   # Rutas de autenticación
```

## 🔐 Características de Seguridad

- ✅ Autenticación con Laravel Breeze
- ✅ Contraseñas hasheadas con bcrypt
- ✅ Protección CSRF en formularios
- ✅ Middleware de autenticación en rutas
- ✅ Validación de permisos (usuarios solo acceden a sus tareas)
- ✅ Validación de datos en servidor
- ✅ Protección contra SQL injection (Eloquent ORM)

## 🚀 Próximas Características (Roadmap)

- [ ] API REST
- [ ] Integración con React/Vue
- [ ] Notificaciones por email
- [ ] Fechas de vencimiento
- [ ] Etiquetas y categorías
- [ ] Colaboración entre usuarios
- [ ] Exportar tareas a PDF/Excel
- [ ] Modo oscuro

## 📸 Screenshots

### Dashboard con estadísticas
<img width="674" height="596" alt="image" src="https://github.com/user-attachments/assets/8ddbe583-9ef7-477c-932f-679cbdd6e4c0" />

### Formulario de creación
<img width="538" height="325" alt="image" src="https://github.com/user-attachments/assets/dae795ac-93f8-44b8-82bf-1b24a2a7292d" />

## 🧪 Testing

Para ejecutar las pruebas:
```bash
php artisan test
```

## 👨‍💻 Autor

**Johan Piedra**
- GitHub: [@jpiedradev](https://github.com/jpiedradev)
- Proyecto: [Task Management Laravel](https://github.com/jpiedradev/task-management-laravel)

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la [MIT License](LICENSE).

## 🙏 Agradecimientos

- Laravel Framework
- Laravel Breeze
- Comunidad de Laravel

---

⭐ Si te gustó este proyecto, dale una estrella en GitHub

📧 Para preguntas o sugerencias, abre un issue en el repositorio

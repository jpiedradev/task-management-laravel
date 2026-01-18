# 📋 Task Manager - Sistema de Gestión de Tareas

Sistema CRUD completo para gestionar tareas con interfaz moderna desarrollado con Laravel, Vue 3, Inertia.js y PrimeVue.

## ✨ Características

### 🎨 Interfaz Moderna
- ✅ SPA (Single Page Application) con Vue 3 + Inertia.js
- ✅ Componentes UI profesionales con PrimeVue
- ✅ Diseño responsive y moderno
- ✅ Modales para crear/editar (sin cambiar de página)
- ✅ Notificaciones toast elegantes
- ✅ Confirmaciones antes de eliminar

### 🔐 Autenticación
- ✅ Sistema completo con Laravel Breeze
- ✅ Login y registro con diseño personalizado
- ✅ Protección de rutas
- ✅ Cada usuario gestiona solo sus tareas

### 📝 Gestión de Tareas
- ✅ CRUD completo (Crear, Leer, Actualizar, Eliminar)
- ✅ Estados: Pendiente, En Progreso, Completada
- ✅ Modales para crear/editar tareas
- ✅ Validaciones en tiempo real
- ✅ Tabla con paginación y ordenamiento

### 🔍 Búsqueda y Filtros
- ✅ Búsqueda por título
- ✅ Filtro por estado
- ✅ Ordenamiento (recientes, antiguos, alfabético)
- ✅ Limpieza de filtros con un clic

### 📊 Dashboard
- ✅ Estadísticas en tiempo real
- ✅ Total de tareas
- ✅ Contadores por estado
- ✅ Tarjetas visuales con colores

### 🚀 API REST
- ✅ Endpoints completos para todas las operaciones
- ✅ Autenticación con Laravel Sanctum
- ✅ Respuestas JSON estandarizadas
- ✅ Búsqueda y filtros en API
- ✅ Documentación de endpoints

## 🛠️ Stack Tecnológico

### Backend
- PHP 8.x
- Laravel 11
- MySQL
- Laravel Sanctum (API)
- Laravel Breeze (Auth)

### Frontend
- Vue 3 (Composition API)
- Inertia.js
- PrimeVue (UI Components)
- Vite

## 📦 Instalación

### Requisitos
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL

### Pasos
```bash
# 1. Clonar repositorio
git clone https://github.com/jpiedradev/task-management-laravel.git
cd task-management-laravel

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar base de datos en .env
DB_DATABASE=task_app
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrar base de datos
php artisan migrate

# 6. Iniciar servidores
php artisan serve
npm run dev
```

Abre: `http://localhost:8000`

## 🎯 Uso

### Aplicación Web
1. Regístrate o inicia sesión
2. Crea tareas usando el botón "Nueva Tarea"
3. Edita haciendo clic en el ícono de lápiz
4. Elimina con el ícono de basura
5. Usa filtros para organizar tus tareas

### API REST

#### Autenticación
```bash
# Login
POST /api/login
Body: { "email": "user@example.com", "password": "password" }
Response: { "token": "..." }

# Usar token
Authorization: Bearer {token}
```

#### Endpoints
```bash
GET    /api/tasks              # Listar tareas
POST   /api/tasks              # Crear tarea
GET    /api/tasks/{id}         # Ver tarea
PUT    /api/tasks/{id}         # Actualizar tarea
DELETE /api/tasks/{id}         # Eliminar tarea
```

#### Ejemplo con filtros
```bash
GET /api/tasks?search=compras&status=pendiente&order=latest
```

## 📁 Estructura
```
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/           # Controladores API
│   │   └── Auth/          # Controladores Auth
│   └── Models/            # Modelos Eloquent
├── resources/
│   ├── js/
│   │   ├── Pages/         # Páginas Vue
│   │   ├── Layouts/       # Layouts
│   │   └── app.js         # Entry point
│   └── views/
│       └── app.blade.php  # Layout base
└── routes/
    ├── web.php            # Rutas web
    └── api.php            # Rutas API
```

## 🔒 Seguridad

- ✅ Autenticación con sesiones (Web) y tokens (API)
- ✅ Contraseñas hasheadas
- ✅ Protección CSRF
- ✅ Middleware de autenticación
- ✅ Validación de permisos por usuario
- ✅ Sanitización de inputs
- ✅ SQL injection prevention (Eloquent)

## 🚀 Próximas Características

- [ ] Fechas de vencimiento
- [ ] Prioridades de tareas
- [ ] Categorías/Etiquetas
- [ ] Archivos adjuntos
- [ ] Notificaciones por email
- [ ] Colaboración entre usuarios
- [ ] Exportar a PDF/Excel

## 👨‍💻 Desarrollo

### Comandos útiles
```bash
# Desarrollo
npm run dev              # Vite dev server
php artisan serve        # Laravel server

# Producción
npm run build            # Build para producción

# Base de datos
php artisan migrate:fresh    # Resetear BD
php artisan migrate:refresh  # Rehacer migraciones

# Cache
php artisan optimize:clear   # Limpiar cache
```

## 📸 Screenshots

### Dashboard
![Dashboard](https://github.com/user-attachments/assets/8ddbe583-9ef7-477c-932f-679cbdd6e4c0)

### Modal de Creación
![Modal](https://github.com/user-attachments/assets/dae795ac-93f8-44b8-82bf-1b24a2a7292d)

## 👨‍💻 Autor

**Johan Piedra**
- GitHub: [@jpiedradev](https://github.com/jpiedradev)
- Email: jpiedra.dev@gmail.com

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

---

⭐ **Si te gustó este proyecto, dale una estrella en GitHub**

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        h1 { color: #333; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; border: none; cursor: pointer; }
        .btn-warning { background: #ffc107; color: black; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; background: #d4edda; color: #155724; }
        .badge { padding: 5px 10px; border-radius: 3px; font-size: 12px; }
        .badge-pendiente { background: #ffc107; }
        .badge-en_progreso { background: #17a2b8; color: white; }
        .badge-completada { background: #28a745; color: white; }
        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .user-info p {
            margin: 0;
            font-size: 16px;
        }
        .user-info strong {
            color: #007bff;
        }
    </style>
</head>
<body>
<h1>📋 Gestión de Tareas</h1>

<!-- NUEVO: Info del usuario y logout -->
<div class="user-info">
    <p>Bienvenido, <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})</p>
    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="btn btn-danger">🚪 Cerrar Sesión</button>
    </form>
</div>

<!-- Tarjetas de estadísticas -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">

    <!-- Total -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;">
        <h2 style="margin: 0; font-size: 36px;">{{ $stats['total'] }}</h2>
        <p style="margin: 5px 0 0 0; opacity: 0.9;">Total de tareas</p>
    </div>

    <!-- Pendientes -->
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;">
        <h2 style="margin: 0; font-size: 36px;">{{ $stats['pendientes'] }}</h2>
        <p style="margin: 5px 0 0 0; opacity: 0.9;">Pendientes</p>
    </div>

    <!-- En Progreso -->
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;">
        <h2 style="margin: 0; font-size: 36px;">{{ $stats['en_progreso'] }}</h2>
        <p style="margin: 5px 0 0 0; opacity: 0.9;">En Progreso</p>
    </div>

    <!-- Completadas -->
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 20px; border-radius: 8px; color: white; text-align: center;">
        <h2 style="margin: 0; font-size: 36px;">{{ $stats['completadas'] }}</h2>
        <p style="margin: 5px 0 0 0; opacity: 0.9;">Completadas</p>
    </div>

</div>

<!-- Formulario de búsqueda y filtros -->
<div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <form action="{{ route('tasks.index') }}" method="GET">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto auto; gap: 15px; align-items: end;">

            <!-- Campo de búsqueda -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    🔍 Buscar por título:
                </label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Escribe para buscar..."
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"
                >
            </div>

            <!-- Filtro por estado -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    📊 Filtrar por estado:
                </label>
                <select
                    name="status"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"
                >
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>
                        Pendiente
                    </option>
                    <option value="en_progreso" {{ request('status') == 'en_progreso' ? 'selected' : '' }}>
                        En Progreso
                    </option>
                    <option value="completada" {{ request('status') == 'completada' ? 'selected' : '' }}>
                        Completada
                    </option>
                </select>
            </div>

            <!-- Ordenar por -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    🔽 Ordenar por:
                </label>
                <select
                    name="order"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"
                >
                    <option value="latest" {{ request('order') == 'latest' ? 'selected' : '' }}>
                        Más recientes
                    </option>
                    <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>
                        Más antiguos
                    </option>
                    <option value="title_asc" {{ request('order') == 'title_asc' ? 'selected' : '' }}>
                        Título (A-Z)
                    </option>
                    <option value="title_desc" {{ request('order') == 'title_desc' ? 'selected' : '' }}>
                        Título (Z-A)
                    </option>
                </select>
            </div>

            <!-- Botón buscar -->
            <div>
                <button
                    type="submit"
                    class="btn btn-primary"
                    style="padding: 10px 20px;"
                >
                    🔍 Buscar
                </button>
            </div>

            <!-- Botón limpiar -->
            <div>
                <a
                    href="{{ route('tasks.index') }}"
                    class="btn btn-secondary"
                    style="padding: 10px 20px; text-decoration: none; display: inline-block;"
                >
                    🔄 Limpiar
                </a>
            </div>

        </div>

        <!-- Mostrar filtros activos -->
        @if(request('search') || request('status'))
            <div style="margin-top: 15px; padding: 10px; background: #e3f2fd; border-radius: 5px;">
                <strong>Filtros activos:</strong>
                @if(request('search'))
                    <span style="background: #fff; padding: 5px 10px; border-radius: 3px; margin-left: 5px;">
                        Búsqueda: "{{ request('search') }}"
                    </span>
                @endif
                @if(request('status'))
                    <span style="background: #fff; padding: 5px 10px; border-radius: 3px; margin-left: 5px;">
                        Estado: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                    </span>
                @endif
            </div>
        @endif
    </form>
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<a href="{{ route('tasks.create') }}" class="btn btn-primary">➕ Nueva Tarea</a>

<!-- Tabla de tareas -->
<table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
    <thead>
    <tr style="background: #f8f9fa;">
        <th style="padding: 15px; text-align: left; border-bottom: 2px solid #dee2e6;">ID</th>
        <th style="padding: 15px; text-align: left; border-bottom: 2px solid #dee2e6;">Título</th>
        <th style="padding: 15px; text-align: left; border-bottom: 2px solid #dee2e6;">Descripción</th>
        <th style="padding: 15px; text-align: left; border-bottom: 2px solid #dee2e6;">Estado</th>
        <th style="padding: 15px; text-align: left; border-bottom: 2px solid #dee2e6;">Fecha</th>
        <th style="padding: 15px; text-align: center; border-bottom: 2px solid #dee2e6;">Acciones</th>
    </tr>
    </thead>
    <tbody>
    @forelse($tasks as $task)
        <tr style="border-bottom: 1px solid #dee2e6;">
            <td style="padding: 15px;">{{ $task->id }}</td>
            <td style="padding: 15px;">
                <strong>{{ $task->title }}</strong>
            </td>
            <td style="padding: 15px;">
                {{ Str::limit($task->description ?? 'Sin descripción', 50) }}
            </td>
            <td style="padding: 15px;">
                @if($task->status == 'pendiente')
                    <span style="background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            ⏳ Pendiente
                        </span>
                @elseif($task->status == 'en_progreso')
                    <span style="background: #cfe2ff; color: #084298; padding: 5px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            🔄 En Progreso
                        </span>
                @else
                    <span style="background: #d1e7dd; color: #0f5132; padding: 5px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            ✅ Completada
                        </span>
                @endif
            </td>
            <td style="padding: 15px; color: #6c757d; font-size: 14px;">
                {{ $task->created_at->format('d/m/Y') }}
            </td>
            <td style="padding: 15px; text-align: center;">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning" style="margin-right: 5px;">
                    ✏️ Editar
                </a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">
                        🗑️ Eliminar
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" style="padding: 40px; text-align: center; color: #6c757d;">
                @if(request('search') || request('status'))
                    <div style="font-size: 48px; margin-bottom: 10px;">🔍</div>
                    <p style="font-size: 18px; margin: 0;">No se encontraron tareas con esos filtros.</p>
                    <a href="{{ route('tasks.index') }}" style="color: #007bff; text-decoration: none; margin-top: 10px; display: inline-block;">
                        Limpiar filtros
                    </a>
                @else
                    <div style="font-size: 48px; margin-bottom: 10px;">📝</div>
                    <p style="font-size: 18px; margin: 0;">No tienes tareas aún.</p>
                    <a href="{{ route('tasks.create') }}" style="color: #007bff; text-decoration: none; margin-top: 10px; display: inline-block;">
                        ¡Crea tu primera tarea!
                    </a>
                @endif
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>

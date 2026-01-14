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

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<a href="{{ route('tasks.create') }}" class="btn btn-primary">➕ Nueva Tarea</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @forelse($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description ?? 'Sin descripción' }}</td>
            <td>
                        <span class="badge badge-{{ $task->status }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
            </td>
            <td>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">✏️ Editar</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">🗑️ Eliminar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align: center;">No hay tareas aún. ¡Crea tu primera tarea!</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>

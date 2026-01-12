<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        h1 { color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .error { color: red; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<h1>✏️ Editar Tarea</h1>

<form action="{{ route('tasks.update', $task) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Título:</label>
        <input type="text" name="title" value="{{ old('title', $task->title) }}" required>
        @error('title')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Descripción:</label>
        <textarea name="description" rows="4">{{ old('description', $task->description) }}</textarea>
        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Estado:</label>
        <select name="status" required>
            <option value="pendiente" {{ $task->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="en_progreso" {{ $task->status == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
            <option value="completada" {{ $task->status == 'completada' ? 'selected' : '' }}>Completada</option>
        </select>
        @error('status')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">💾 Actualizar</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">❌ Cancelar</a>
</form>
</body>
</html>

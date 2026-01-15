<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Mostrar todas las tareas
    public function index(Request $request)
    {
        //$tasks = Task::all();
        // Inicia la consulta con las tareas del usuario
        $query = auth()->user()->tasks();

        // Búsqueda por título
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtro por estado
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // NUEVO: Ordenamiento
        $orderBy = $request->get('order', 'latest'); // Por defecto: más recientes

        switch ($orderBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Obtener las tareas
        $tasks = $query->get();

        // NUEVO: Calcular estadísticas
        $stats = [
            'total' => auth()->user()->tasks()->count(),
            'pendientes' => auth()->user()->tasks()->where('status', 'pendiente')->count(),
            'en_progreso' => auth()->user()->tasks()->where('status', 'en_progreso')->count(),
            'completadas' => auth()->user()->tasks()->where('status', 'completada')->count(),
        ];

        return view('tasks.index', compact('tasks','stats'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        return view('tasks.create');
    }

    // Guardar nueva tarea
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pendiente,en_progreso,completada'
        ]);

        // Agrega el user_id del usuario logueado
        $validated['user_id'] = auth()->id();

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', '¡Tarea creada exitosamente!');
    }

    // Mostrar formulario para editar
    public function edit(Task $task)
    {
        // Protección: solo el usuario dueño puede editar
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta tarea');
        }

        return view('tasks.edit', compact('task'));
    }

    // Actualizar tarea
    public function update(Request $request, Task $task)
    {
        // Protección: solo el dueño puede actualizar
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar esta tarea');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pendiente,en_progreso,completada'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', '¡Tarea actualizada exitosamente!');
    }

    // Eliminar tarea
    public function destroy(Task $task)
    {
        // Protección: solo el dueño puede eliminar
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta tarea');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', '¡Tarea eliminada exitosamente!');
    }
}

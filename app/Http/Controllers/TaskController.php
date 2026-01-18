<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        // Búsqueda por título
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtro por estado
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Ordenamiento
        $orderBy = $request->get('order', 'latest');
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

        $tasks = $query->get();

        $stats = [
            'total' => auth()->user()->tasks()->count(),
            'pendientes' => auth()->user()->tasks()->where('status', 'pendiente')->count(),
            'en_progreso' => auth()->user()->tasks()->where('status', 'en_progreso')->count(),
            'completadas' => auth()->user()->tasks()->where('status', 'completada')->count(),
        ];

        // ❌ ANTES (Blade):
        // return view('tasks.index', compact('tasks', 'stats'));

        // ✅ AHORA (Inertia):
        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
                'order' => $orderBy,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pendiente,en_progreso,completada'
        ]);

        $validated['user_id'] = auth()->id();

        Task::create($validated);

        // ❌ ANTES:
        // return redirect()->route('tasks.index')->with('success', '¡Tarea creada exitosamente!');

        // ✅ AHORA (Inertia maneja el redirect automáticamente):
        return redirect()->route('tasks.index')->with('success', '¡Tarea creada exitosamente!');
    }

    public function update(Request $request, Task $task)
    {
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

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta tarea');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', '¡Tarea eliminada exitosamente!');
    }
}

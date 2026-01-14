<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Mostrar todas las tareas
    public function index()
    {
        //$tasks = Task::all();
        $tasks = auth()->user()->tasks;
        return view('tasks.index', compact('tasks'));
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

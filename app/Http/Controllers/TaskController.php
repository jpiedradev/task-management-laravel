<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Mostrar todas las tareas
    public function index()
    {
        $tasks = Task::all();
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
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pendiente,en_progreso,completada'
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', '¡Tarea creada exitosamente!');
    }

    // Mostrar formulario para editar
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Actualizar tarea
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pendiente,en_progreso,completada'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', '¡Tarea actualizada exitosamente!');
    }

    // Eliminar tarea
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', '¡Tarea eliminada exitosamente!');
    }
}

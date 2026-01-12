<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\SuerteController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('pruebas', [ExampleController::class, 'index']);

/* Numeros al azar - Loteria*/
Route::get('suerte', [SuerteController::class, 'alAzar'])->name('suerte.alazar');
Route::get('/suerte/generar', [SuerteController::class, 'generar'])->name('suerte.generar');

/* Proyecto de tareas*/
Route::get('/', function () {
    return redirect('/tasks');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');


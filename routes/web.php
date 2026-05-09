<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

Route::get('/', function () {
    return view('welcome');
    // return redirect()->route('tasks.index');
});

// Tasks routes
Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TasksController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/{id}/restore', [TasksController::class, 'restore'])->name('tasks.restore');
Route::delete('/tasks/{id}/force-delete', [TasksController::class, 'forceDelete'])->name('tasks.forceDelete');

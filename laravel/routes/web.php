<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas del panel admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/panel', [AdminController::class, 'index'])->name('panel');
    Route::post('/crear', [AdminController::class, 'crear'])->name('crear');
    Route::get('/editar/{id}', [AdminController::class, 'editar'])->name('editar');
    Route::post('/actualizar/{id}', [AdminController::class, 'actualizar'])->name('actualizar');
    Route::get('/cancelar/{id}', [AdminController::class, 'cancelar'])->name('cancelar');
    Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])->name('asignarTecnico');
    Route::get('/calendario', [AdminController::class, 'calendario'])->name('calendario');
    Route::get('/liquidaciones', [AdminController::class, 'liquidaciones'])->name('liquidaciones');
});
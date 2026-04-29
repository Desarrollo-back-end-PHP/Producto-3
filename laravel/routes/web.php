<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mis-avisos', [IncidenciaController::class, 'index'])->name('incidencias.index');
    Route::get('/nueva-solicitud', [IncidenciaController::class, 'create'])->name('incidencias.create');
    Route::post('/nueva-solicitud', [IncidenciaController::class, 'store'])->name('incidencias.store');
    Route::delete('/incidencias/{id}', [IncidenciaController::class, 'destroy'])->name('incidencias.destroy');
});

require __DIR__.'/auth.php';
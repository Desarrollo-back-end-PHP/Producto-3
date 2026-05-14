<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestoraController;
use App\Http\Controllers\TecnicoController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::middleware(['auth'])->group(function () {

    Route::get('/notificaciones', function () {
        $notificaciones = auth()->user()->notificaciones()->latest()->get();
        return view('notificaciones.index', compact('notificaciones'));
    })->name('notificaciones.index');

    Route::post('/notificaciones/leidas', function () {
        auth()->user()->notificacionesNoLeidas()->update(['leida' => 1]);
        return back();
    })->name('notificaciones.leidas');

    Route::get('/dashboard', function () {
        return match (auth()->user()->rol) {
            'admin'   => redirect()->route('admin.panel'),
            'gestora' => redirect()->route('gestora.panel'),
            'tecnico' => redirect()->route('tecnico.panel'),
            default   => view('dashboard'),
        };
    })->name('dashboard');

    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [UserController::class, 'actualizarPerfil'])->name('perfil.update');

    // INCIDENCIAS CLIENTE
    Route::get('/mis-avisos', [IncidenciaController::class, 'index'])->name('incidencias.index');
    Route::get('/nueva-solicitud', [IncidenciaController::class, 'create'])->name('incidencias.create');
    Route::post('/nueva-solicitud', [IncidenciaController::class, 'store'])->name('incidencias.store');
    Route::delete('/incidencias/{id}', [IncidenciaController::class, 'destroy'])->name('incidencias.destroy');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/panel', [AdminController::class, 'index'])->name('panel');
        Route::post('/crear', [AdminController::class, 'crear'])->name('crear');
        Route::post('/actualizar/{id}', [AdminController::class, 'actualizar'])->name('actualizar');
        Route::post('/cancelar/{id}', [AdminController::class, 'cancelar'])->name('cancelar');
        Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])->name('asignarTecnico');
        Route::get('/calendario', [AdminController::class, 'calendario'])->name('calendario');
        Route::get('/liquidaciones', [AdminController::class, 'liquidaciones'])->name('liquidaciones');
        Route::post('/comisiones/liquidar', [AdminController::class, 'liquidarComisiones'])->name('comisiones.liquidar');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users/create', [UserController::class, 'storeAdmin'])->name('users.store');
        Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/tecnicos', [AdminController::class, 'tecnicos'])->name('tecnicos');
        Route::post('/tecnicos/create', [AdminController::class, 'storeTecnico'])->name('tecnicos.store');
        Route::post('/tecnicos/{id}/update', [AdminController::class, 'updateTecnico'])->name('tecnicos.update');
        Route::post('/tecnicos/{id}/baja', [AdminController::class, 'darDeBaja'])->name('tecnicos.baja');
        Route::get('/servicios', [\App\Http\Controllers\EspecialidadController::class, 'index'])->name('servicios');
        Route::post('/servicios', [\App\Http\Controllers\EspecialidadController::class, 'store'])->name('servicios.store');
        Route::post('/servicios/bulk', [\App\Http\Controllers\EspecialidadController::class, 'bulk'])->name('servicios.bulk');
        Route::post('/servicios/{id}/update', [\App\Http\Controllers\EspecialidadController::class, 'update'])->name('servicios.update');
        Route::post('/servicios/{id}/delete', [\App\Http\Controllers\EspecialidadController::class, 'destroy'])->name('servicios.destroy');
    });

    Route::prefix('gestora')->name('gestora.')->middleware('role:gestora')->group(function () {
        Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])->name('asignarTecnico');
        Route::get('/', [GestoraController::class, 'index'])->name('panel');
        Route::post('/crear', [GestoraController::class, 'crear'])->name('crear');
        Route::post('/avisos/{id}/cancelar', [GestoraController::class, 'cancelarAviso'])->name('avisos.cancelar');
    });

    Route::prefix('tecnico')->name('tecnico.')->middleware('role:tecnico')->group(function () {
        Route::get('/', [TecnicoController::class, 'index'])->name('panel');
        Route::post('/estado', [TecnicoController::class, 'cambiarEstado'])->name('estado');
    });

});
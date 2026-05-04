<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestoraController;
use App\Http\Controllers\TecnicoController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT / REGISTRO
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (requieren login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Marcar todas las notificaciones como leídas
    Route::post('/notificaciones/leidas', function () {
        auth()->user()->notificacionesNoLeidas()->update(['leida' => 1]);
        return back();
    })->name('notificaciones.leidas');

    // Dashboard: redirige según el rol del usuario
    Route::get('/dashboard', function () {
        return match (auth()->user()->rol) {
            'admin'   => redirect()->route('admin.panel'),
            'gestora' => redirect()->route('gestora.panel'),
            'tecnico' => redirect()->route('tecnico.panel'),
            default   => view('dashboard'),
        };
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [UserController::class, 'actualizarPerfil'])->name('perfil.update');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/panel', [AdminController::class, 'index'])->name('panel');

        // Avisos
        Route::post('/crear', [AdminController::class, 'crear'])->name('crear');
        Route::post('/actualizar/{id}', [AdminController::class, 'actualizar'])->name('actualizar');
        Route::post('/cancelar/{id}', [AdminController::class, 'cancelar'])->name('cancelar');
        Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])->name('asignarTecnico');

        // Vistas extra
        Route::get('/calendario', [AdminController::class, 'calendario'])->name('calendario');
        Route::get('/liquidaciones', [AdminController::class, 'liquidaciones'])->name('liquidaciones');
        Route::post('/comisiones/liquidar', [AdminController::class, 'liquidarComisiones'])->name('comisiones.liquidar');

        // Usuarios
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users/create', [UserController::class, 'storeAdmin'])->name('users.store');
        Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');

        // Técnicos
        Route::get('/tecnicos', [AdminController::class, 'tecnicos'])->name('tecnicos');
        Route::post('/tecnicos/create', [AdminController::class, 'storeTecnico'])->name('tecnicos.store');
        Route::post('/tecnicos/{id}/update', [AdminController::class, 'updateTecnico'])->name('tecnicos.update');
        Route::post('/tecnicos/{id}/baja', [AdminController::class, 'darDeBaja'])->name('tecnicos.baja');

        // Servicios (tipos de servicio / especialidades)
        Route::get('/servicios', [\App\Http\Controllers\EspecialidadController::class, 'index'])->name('servicios');
        Route::post('/servicios', [\App\Http\Controllers\EspecialidadController::class, 'store'])->name('servicios.store');
        Route::post('/servicios/bulk', [\App\Http\Controllers\EspecialidadController::class, 'bulk'])->name('servicios.bulk');
        Route::post('/servicios/{id}/update', [\App\Http\Controllers\EspecialidadController::class, 'update'])->name('servicios.update');
        Route::post('/servicios/{id}/delete', [\App\Http\Controllers\EspecialidadController::class, 'destroy'])->name('servicios.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTORA
    |--------------------------------------------------------------------------
    */
    Route::prefix('gestora')->name('gestora.')->middleware('role:gestora')->group(function () {
        Route::get('/', [GestoraController::class, 'index'])->name('panel');
        Route::post('/crear', [GestoraController::class, 'crear'])->name('crear');
        Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])->name('asignarTecnico');
        Route::post('/avisos/{id}/cancelar', [GestoraController::class, 'cancelarAviso'])->name('avisos.cancelar');
    });

    /*
    |--------------------------------------------------------------------------
    | TECNICO
    |--------------------------------------------------------------------------
    */
    Route::prefix('tecnico')->name('tecnico.')->middleware('role:tecnico')->group(function () {
        Route::get('/', [TecnicoController::class, 'index'])->name('panel');
        Route::post('/estado', [TecnicoController::class, 'cambiarEstado'])->name('estado');
    });

});

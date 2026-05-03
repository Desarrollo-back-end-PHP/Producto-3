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
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| REGISTRO
|--------------------------------------------------------------------------
*/
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 🔔 NOTIFICACIONES (GLOBAL)
    Route::post('/notificaciones/leidas', function () {
        auth()->user()->notificacionesNoLeidas()->update(['leida' => 1]);
        return back();
    })->name('notificaciones.leidas');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
    return match (auth()->user()->rol) {
        'admin'   => redirect()->route('admin.panel'),
        'gestora' => redirect()->route('gestora.panel'),
        'tecnico' => redirect()->route('tecnico.panel'),
        default   => view('dashboard'),
    };
})->name('dashboard');

    //Usuario 
    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
Route::post('/perfil', [UserController::class, 'actualizarPerfil'])->name('perfil.update');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/panel', [AdminController::class, 'index'])->name('panel');

        // 🔥 AVISOS
        Route::post('/crear', [AdminController::class, 'crear'])->name('crear');
        Route::post('/actualizar/{id}', [AdminController::class, 'actualizar'])->name('actualizar');

        // 🔥 ESTAS SON LAS QUE TE FALTABAN
        Route::get('/editar/{id}', [AdminController::class, 'editar'])->name('editar');
        Route::get('/cancelar/{id}', [AdminController::class, 'cancelar'])->name('cancelar');

        // 🔥 ASIGNACIONES
        Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])->name('asignarTecnico');

        // 🔥 EXTRAS
        Route::get('/calendario', [AdminController::class, 'calendario'])->name('calendario');
        Route::get('/liquidaciones', [AdminController::class, 'liquidaciones'])->name('liquidaciones');

        Route::post('/comisiones/liquidar', [AdminController::class, 'liquidarComisiones'])->name('comisiones.liquidar');

        // 🔥 USUARIOS
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    });

    /*
    |--------------------------------------------------------------------------
    | GESTORA
    |--------------------------------------------------------------------------
    */
    Route::prefix('gestora')->name('gestora.')->middleware('role:gestora')->group(function () {
Route::post('/asignar-tecnico', [AdminController::class, 'asignarTecnico'])
    ->name('asignarTecnico');
        Route::get('/', [GestoraController::class, 'index'])->name('panel');
        Route::post('/crear', [GestoraController::class, 'crear'])->name('crear');
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
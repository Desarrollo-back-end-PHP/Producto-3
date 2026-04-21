<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComisionController;

// 🔹 LOGIN + REGISTER
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/registro', [AuthController::class, 'showRegister']);
    Route::post('/registro', [AuthController::class, 'register']);
});

// 🔹 PROTEGIDO
Route::middleware('auth')->group(function () {

    // PANEL
    Route::get('/panel', [UsuarioController::class, 'panel']);

    // 👤 EDITAR PERFIL
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);

    // 💰 COMISIONES (TODOS)
    Route::get('/comisiones', [ComisionController::class, 'index']);

    // 🔴 SOLO ADMIN
    Route::middleware('rol:admin')->group(function () {
        Route::get('/comisiones/{id}/edit', [ComisionController::class, 'edit']);
Route::put('/comisiones/{id}', [ComisionController::class, 'update']);

        // USUARIOS
        Route::get('/usuarios', [UsuarioController::class, 'index']);
        Route::get('/usuarios/create', [UsuarioController::class, 'create']);
        Route::post('/usuarios', [UsuarioController::class, 'store']);
        Route::post('/usuarios/{id}/delete', [UsuarioController::class, 'destroy']);

        // COMISIONES
        Route::get('/comisiones/create', [ComisionController::class, 'create']);
        Route::post('/comisiones', [ComisionController::class, 'store']);
        Route::post('/comisiones/{id}/delete', [ComisionController::class, 'destroy']);
        Route::get('/comisiones/{id}/edit', [ComisionController::class, 'edit']);
Route::put('/comisiones/{id}', [ComisionController::class, 'update']);
    });

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout']);
});

// HOME
Route::get('/', function () {
    return view('home');
});
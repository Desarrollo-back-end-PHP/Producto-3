<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiciosController;

Route::get('/servicios/zonas', [ServiciosController::class, 'zonas']);
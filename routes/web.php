<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\TipoPrestamoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('tipos-prestamo', TipoPrestamoController::class);
Route::apiResource('prestamos', PrestamoController::class);
Route::apiResource('cuotas', CuotaController::class)->only(['index', 'show', 'destroy']);
Route::apiResource('pagos', PagoController::class)->only(['index', 'show', 'store', 'destroy']);

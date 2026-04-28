<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\TipoPrestamoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('clientes', ClienteController::class);
Route::resource('tipos-prestamo', TipoPrestamoController::class);
Route::resource('prestamos', PrestamoController::class);
Route::resource('cuotas', CuotaController::class)->only(['index', 'show', 'destroy']);
Route::resource('pagos', PagoController::class)->except(['show', 'update']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

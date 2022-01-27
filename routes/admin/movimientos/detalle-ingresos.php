<?php

use App\Http\Controllers\Admin\Movimientos\DetalleIngresosController;
use Illuminate\Support\Facades\Route;

// Detalle ingresos
Route::post('detalle-ingresos/store', [DetalleIngresosController::class, 'store'])->name('detalle-ingresos.store');
Route::post('detalle-ingresos/check', [DetalleIngresosController::class, 'check'])->name('detalle-ingresos.check');

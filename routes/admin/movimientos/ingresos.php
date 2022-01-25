<?php

use App\Http\Controllers\Admin\Movimientos\IngresoController;
use Illuminate\Support\Facades\Route;

// Ingresos
Route::get('ingresos', [IngresoController::class, 'index'])->name('ingresos.index');
Route::get('ingresos/add', [IngresoController::class, 'add'])->name('ingresos.add');
Route::post('ingresos/store', [IngresoController::class, 'store'])->name('ingresos.store');
Route::get('ingresos/edit', [IngresoController::class, 'edit'])->name('ingresos.edit');
Route::post('ingresos/update', [IngresoController::class, 'update'])->name('ingresos.update');
Route::post('ingresos/destroy', [IngresoController::class, 'destroy'])->name('ingresos.destroy');

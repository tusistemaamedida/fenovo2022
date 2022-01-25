<?php

use App\Http\Controllers\Admin\IngresosController;
use Illuminate\Support\Facades\Route;

// Ingresos
Route::get('ingresos', [IngresosController::class, 'index'])->name('ingresos.index');
Route::get('ingresos/add', [IngresosController::class, 'add'])->name('ingresos.add');
Route::post('ingresos/store', [IngresosController::class, 'store'])->name('ingresos.store');
Route::get('ingresos/edit', [IngresosController::class, 'edit'])->name('ingresos.edit');
Route::post('ingresos/update', [IngresosController::class, 'update'])->name('ingresos.update');
Route::post('ingresos/destroy', [IngresosController::class, 'destroy'])->name('ingresos.destroy');

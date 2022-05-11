<?php

use App\Http\Controllers\Admin\Movimientos\DetalleIngresosController;
use App\Http\Controllers\Admin\Movimientos\IngresosController;
use Illuminate\Support\Facades\Route;

// Ingresos
Route::get('ingresos', [IngresosController::class, 'index'])->name('ingresos.index');
Route::get('ingresos/cerras', [IngresosController::class, 'indexCerradas'])->name('ingresos.indexCerradas');

Route::get('ingresos/add', [IngresosController::class, 'add'])->name('ingresos.add');
Route::post('ingresos/store', [IngresosController::class, 'store'])->name('ingresos.store');
Route::get('ingresos/close', [IngresosController::class, 'close'])->name('ingresos.close');
Route::get('ingresos/edit', [IngresosController::class, 'edit'])->name('ingresos.edit');
Route::get('ingresos/edit-ingreso', [IngresosController::class, 'editIngreso'])->name('ingresos.editIngreso');
Route::post('ingresos/update-ingreso', [IngresosController::class, 'updateIngreso'])->name('ingresos.updateIngreso');

Route::get('ingresos/edit-producto', [IngresosController::class, 'editProduct'])->name('ingresos.editProduct');
Route::post('ingresos/update-producto', [IngresosController::class, 'updateProduct'])->name('ingresos.updateProduct');

Route::get('ingresos/show', [IngresosController::class, 'show'])->name('ingresos.show');
Route::post('ingresos/update', [IngresosController::class, 'update'])->name('ingresos.update');
Route::post('ingresos/destroy', [IngresosController::class, 'destroy'])->name('ingresos.destroy');

Route::get('ingresos/movimentos', [IngresosController::class, 'getMovements'])->name('get.movements.ingreso');
Route::get('ingresos/proveedores', [IngresosController::class, 'getProveedorIngreso'])->name('get.proveedor.ingreso');

// Detalle ingresos
Route::post('detalle-ingresos/store', [DetalleIngresosController::class, 'store'])->name('detalle-ingresos.store');
Route::post('detalle-ingresos/check', [DetalleIngresosController::class, 'check'])->name('detalle-ingresos.check');
Route::post('detalle-ingresos/destroy', [DetalleIngresosController::class, 'destroy'])->name('detalle-ingresos.destroy');

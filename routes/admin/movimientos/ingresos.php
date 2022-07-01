<?php

use App\Http\Controllers\Admin\Movimientos\DetalleIngresosController;
use App\Http\Controllers\Admin\Movimientos\IngresosController;
use Illuminate\Support\Facades\Route;

// Ingresos
Route::get('ingresos', [IngresosController::class, 'index'])->name('ingresos.index');
Route::get('ingresos/cerradas', [IngresosController::class, 'indexCerradas'])->name('ingresos.indexCerradas');

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
Route::post('ingresos/destroyTemp', [IngresosController::class, 'destroyTemp'])->name('ingresos.destroyTemp');

Route::get('ingresos/proveedores', [IngresosController::class, 'getProveedorIngreso'])->name('get.proveedor.ingreso');

// Ajustar Stock entre depositos
Route::get('ingresos/ajustar/index', [IngresosController::class, 'indexAjustarStock'])->name('ingresos.ajustarStockIndex');
Route::get('ingresos/ajustar/stockDepositos', [IngresosController::class, 'ajustarStockDepositos'])->name('ingresos.ajustarStockDepositos.add');
Route::get('ingresos/ajustar/stockDepositos/edit/{id}', [IngresosController::class, 'ajustarStockDepositosEdit'])->name('ingresos.ajustarStockDepositos.edit');
Route::get('ingresos/ajustar/stockDepositos/show/{id}', [IngresosController::class, 'ajustarStockDepositosShow'])->name('ingresos.ajustarStockDepositos.show');
Route::post('ingresos/ajustar/storeDetalle', [IngresosController::class, 'ajustarStockStoreDetalle'])->name('ingresos.ajuste-detalle.store');
Route::get('ingresos/movimientos/getMovements', [IngresosController::class, 'getMovements'])->name('ingresos.getMovements');
Route::post('ingresos/check', [IngresosController::class, 'check'])->name('ingresos.check');
Route::get('ingresos/ajustar/stockDepositos/close', [IngresosController::class, 'ajustarStockDepositosClose'])->name('ingresos.close.ajuste');

// Ajustar Stock de las compras
Route::post('ingresos/ajustar/item', [IngresosController::class, 'ajustarIngresoItem'])->name('ajustar.ingreso.item');


// Detalle ingresos
Route::get('detalle-ingresos/movimentos', [DetalleIngresosController::class, 'getMovements'])->name('detalle-movimiento.getMovements');
Route::post('detalle-ingresos/destroy', [DetalleIngresosController::class, 'destroy'])->name('detalle-ingresos.destroy');
Route::post('detalle-ingresos/store', [DetalleIngresosController::class, 'store'])->name('detalle-ingresos.store');
Route::post('detalle-ingresos/check', [DetalleIngresosController::class, 'check'])->name('detalle-ingresos.check');


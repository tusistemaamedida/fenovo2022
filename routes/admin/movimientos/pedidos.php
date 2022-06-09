<?php

use App\Http\Controllers\Admin\Movimientos\DetallesPedidosController;
use App\Http\Controllers\Admin\Movimientos\PedidosController;
use Illuminate\Support\Facades\Route;

// Ingresos
Route::get('pedidos', [PedidosController::class, 'index'])->name('pedidos.index');
Route::get('preparar-pedido', [PedidosController::class, 'prepararPedido'])->name('preparar.pedido');

Route::get('pedidos/estados', [PedidosController::class, 'indexEstados'])->name('pedidos.indexEstados');

Route::get('pedidos/add', [PedidosController::class, 'add'])->name('pedidos.add');
Route::post('pedidos/store', [PedidosController::class, 'store'])->name('pedidos.store');
Route::get('pedidos/close', [PedidosController::class, 'close'])->name('pedidos.close');
Route::get('pedidos/edit', [PedidosController::class, 'edit'])->name('pedidos.edit');
Route::get('pedidos/edit-ingreso', [PedidosController::class, 'editIngreso'])->name('pedidos.editIngreso');
Route::post('pedidos/update-ingreso', [PedidosController::class, 'updateIngreso'])->name('pedidos.updateIngreso');

Route::get('pedidos/edit-producto', [PedidosController::class, 'editProduct'])->name('pedidos.editProduct');
Route::post('pedidos/update-producto', [PedidosController::class, 'updateProduct'])->name('pedidos.updateProduct');

Route::get('pedidos/show', [PedidosController::class, 'show'])->name('pedidos.show');
Route::post('pedidos/update', [PedidosController::class, 'update'])->name('pedidos.update');
Route::post('pedidos/destroy', [PedidosController::class, 'destroy'])->name('pedidos.destroy');
Route::post('pedidos/destroyTemp', [PedidosController::class, 'destroyTemp'])->name('pedidos.destroyTemp');

// Detalle pedidos
Route::get('detalle-pedidos/movimentos', [PedidosController::class, 'getMovements'])->name('detalle-pedido.getMovements');
Route::post('detalle-pedidos/destroy', [PedidosController::class, 'destroyProduct'])->name('detalle-pedidos.destroy');
Route::post('detalle-pedidos/store', [PedidosController::class, 'storeDetallesPedido'])->name('detalle-pedidos.store');
Route::post('detalle-pedidos/check', [PedidosController::class, 'check'])->name('detalle-pedidos.check');

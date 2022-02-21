<?php

use App\Http\Controllers\Admin\Movimientos\NotasCreditoController;
use Illuminate\Support\Facades\Route;

// Salidas
Route::get('notas-de-credito', [NotasCreditoController::class, 'index'])->name('nc.index');
Route::get('notas-de-credito/add', [NotasCreditoController::class, 'add'])->name('nc.add');/*
Route::get('notas-de-credito/show', [NotasCreditoController::class, 'show'])->name('salidas.show');

Route::get('clientes/salidas', [NotasCreditoController::class, 'getClienteSalida'])->name('get.cliente.salida');
Route::get('search-products', [NotasCreditoController::class, 'searchProducts'])->name('search.products');
Route::get('session-products-by-list-id', [NotasCreditoController::class, 'getSessionProducts'])->name('get.session.products');
Route::get('flete-by-list-id', [NotasCreditoController::class, 'getFleteSessionProducts'])->name('get.flete.session.products');

Route::post('delete-session-product', [NotasCreditoController::class, 'deleteSessionProduct'])->name('delete.item.session.produc');
Route::post('store-session-product', [NotasCreditoController::class, 'storeSessionProduct'])->name('store.session.product');
Route::post('store-session-product-item', [NotasCreditoController::class, 'storeSessionProductItem'])->name('store.session.product.item');

Route::post('guardar-salida', [NotasCreditoController::class, 'storeSalida'])->name('guardar.salida');
Route::post('cambiar-facturacion', [NotasCreditoController::class, 'changeInvoiceProduct'])->name('change.invoice.product');
Route::get('get-presentaciones', [NotasCreditoController::class, 'getPresentaciones'])->name('get.presentaciones');

Route::post('salidas-pendiente/destroy', [NotasCreditoController::class, 'pendienteDestroy'])->name('salidas.pendiente.destroy'); */

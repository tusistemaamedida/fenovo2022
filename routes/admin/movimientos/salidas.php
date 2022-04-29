<?php

use App\Http\Controllers\Admin\Movimientos\SalidasController;
use Illuminate\Support\Facades\Route;

// Salidas
Route::get('salidas', [SalidasController::class, 'index'])->name('salidas.index');
Route::get('salidas-pendientes', [SalidasController::class, 'pendientes'])->name('salidas.pendientes');
Route::get('salidas/add', [SalidasController::class, 'add'])->name('salidas.add');
Route::get('salidas/show', [SalidasController::class, 'show'])->name('salidas.show');
Route::get('salidas-pendiente/show', [SalidasController::class, 'pendienteShow'])->name('salidas.pendiente.show');

Route::get('clientes/salidas', [SalidasController::class, 'getClienteSalida'])->name('get.cliente.salida');
Route::get('search-products', [SalidasController::class, 'searchProducts'])->name('search.products');
Route::get('session-products-by-list-id', [SalidasController::class, 'getSessionProducts'])->name('get.session.products');
Route::get('flete-by-list-id', [SalidasController::class, 'getFleteSessionProducts'])->name('get.flete.session.products');

Route::post('delete-session-product', [SalidasController::class, 'deleteSessionProduct'])->name('delete.item.session.produc');
Route::post('store-session-product', [SalidasController::class, 'storeSessionProduct'])->name('store.session.product');
Route::post('store-session-product-item', [SalidasController::class, 'storeSessionProductItem'])->name('store.session.product.item');

Route::post('guardar-salida', [SalidasController::class, 'storeSalida'])->name('guardar.salida');
Route::post('cambiar-facturacion', [SalidasController::class, 'changeInvoiceProduct'])->name('change.invoice.product');
Route::get('get-presentaciones', [SalidasController::class, 'getPresentaciones'])->name('get.presentaciones');

Route::post('salidas-pendiente/destroy', [SalidasController::class, 'pendienteDestroy'])->name('salidas.pendiente.destroy');

Route::get('salidas-pendiente/print', [SalidasController::class, 'pendientePrint'])->name('salidas.pendiente.print');
Route::post('imprimir-remito', [SalidasController::class, 'printRemito'])->name('print.remito');
Route::get('imprimir-papers/', [SalidasController::class, 'printPanama'])->name('print.panama');
Route::get('imprimir-flete/', [SalidasController::class, 'printPanamaFlete'])->name('print.panama.felete');
Route::get('total-del-movimiento', [SalidasController::class, 'getTotalMovement'])->name('get.total.movement');

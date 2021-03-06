<?php

use App\Http\Controllers\Admin\Movimientos\SalidasController;
use Illuminate\Support\Facades\Route;

// Salidas
Route::get('salidas', [SalidasController::class, 'index'])->name('salidas.index');
Route::get('salidas/add', [SalidasController::class, 'add'])->name('salidas.add');
Route::get('salidas/show', [SalidasController::class, 'show'])->name('salidas.show');

Route::get('salidas-pendientes', [SalidasController::class, 'pendientes'])->name('salidas.pendientes');
Route::get('salidas-pendiente/show', [SalidasController::class, 'pendienteShow'])->name('salidas.pendiente.show');
Route::get('salidas-pendiente/motivo', [SalidasController::class, 'pendienteMotivoDestroy'])->name('salidas.pendienteMotivo');
Route::post('salidas-pendiente/destroy', [SalidasController::class, 'pendienteDestroy'])->name('salidas.pendiente.destroy');
Route::get('salidas-pendiente/print', [SalidasController::class, 'pendientePrint'])->name('salidas.pendiente.print');

Route::get('clientes/salidas', [SalidasController::class, 'getClienteSalida'])->name('get.cliente.salida');
Route::get('search-products', [SalidasController::class, 'searchProducts'])->name('search.products');
Route::get('buscar-productos', [SalidasController::class, 'buscarProductos'])->name('buscar.productos');

Route::get('session-products-by-list-id', [SalidasController::class, 'getSessionProducts'])->name('get.session.products');
Route::get('flete-by-list-id', [SalidasController::class, 'getFleteSessionProducts'])->name('get.flete.session.products');

Route::post('delete-session-product', [SalidasController::class, 'deleteSessionProduct'])->name('delete.item.session.produc');
Route::post('store-session-product', [SalidasController::class, 'storeSessionProduct'])->name('store.session.product');
Route::post('store-session-product-item', [SalidasController::class, 'storeSessionProductItem'])->name('store.session.product.item');

Route::post('guardar-salida', [SalidasController::class, 'storeSalida'])->name('guardar.salida');
/* Route::post('cambiar-facturacion', [SalidasController::class, 'changeInvoiceProduct'])->name('change.invoice.product'); */
Route::post('cambiar-facturacion-de-produto', [SalidasController::class, 'changeInvoiceProduct'])->name('change.product.invoice');
Route::get('get-presentaciones', [SalidasController::class, 'getPresentaciones'])->name('get.presentaciones');

Route::post('imprimir-remito', [SalidasController::class, 'printRemito'])->name('print.remito');
Route::get('imprimir-orden', [SalidasController::class, 'printOrden'])->name('print.orden');
Route::get('imprimir-orden-panama', [SalidasController::class, 'printOrdenPanama'])->name('print.ordenPanama');
Route::get('imprimir-ordenes/{id}', [SalidasController::class, 'printOrdenes'])->name('print.ordenes');

Route::get('ver-orden/consolidada', [SalidasController::class, 'indexOrdenConsolidada'])->name('index.ordenConsolidada');
Route::get('imprimir-orden/consolidada', [SalidasController::class, 'printOrdenConsolidada'])->name('print.ordenConsolidada');

Route::get('imprimir-papers/', [SalidasController::class, 'printPanama'])->name('print.panama');
Route::get('imprimir-flete/', [SalidasController::class, 'printPanamaFlete'])->name('print.panama.felete');
Route::get('total-del-movimiento', [SalidasController::class, 'getTotalMovement'])->name('get.total.movement');

Route::get('actualizar-stock-factura', [SalidasController::class, 'updateStockFactura'])->name('update.stock.factura');

Route::get('update-jurisdiccion', [SalidasController::class, 'updateJurisdiccion']);
Route::post('salidas-pendiente-cambiar-pausa', [SalidasController::class, 'cambiarPausaSalida'])->name('cambiar.pausa.salida');

Route::get('actualizar-stock/{code?}', [SalidasController::class, 'updateStock'])->name('update.stock');


Route::get('pre-factura/{movment_id}', [SalidasController::class, 'previewCreateInvoice'])->name('pre.invoice');
Route::get('get-productos-invoice', [SalidasController::class, 'cargarProductos'])->name('get.productos');

<?php

use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('productos', [ProductController::class, 'list'])->name('products.list');

Route::get('productos/add', [ProductController::class, 'add'])->middleware('can:products.create')->name('product.add');
Route::post('productos/store', [ProductController::class, 'store'])->name('product.store');

Route::get('product-validate-code', [ProductController::class, 'validateCode'])->name('product.validate.code');
Route::get('calculate-product-prices', [ProductController::class, 'calculateProductPrices'])->name('calculate.product.prices');
Route::get('descuento-por-rubro', [ProductController::class, 'getDescuentoAplicado'])->name('get.descuento.aplicado');

Route::post('productos/destroy', [ProductController::class, 'destroy'])->middleware('can:products.edit')->name('product.destroy');

Route::get('producto/edit/{fecha_actualizacion?}', [ProductController::class, 'edit'])->middleware('can:products.edit')->name('product.edit');

Route::get('producto/ver/{id?}', [ProductController::class, 'ver'])->middleware('can:products.edit')->name('product.ver');

Route::post('producto/update', [ProductController::class, 'update'])->name('product.update');
Route::post('producto/actualizar-precios', [ProductController::class, 'updatePrices'])->name('actualizar.precios');
Route::post('producto/actualizar-oferta', [ProductController::class, 'updateOferta'])->name('actualizar.oferta');

Route::post('producto/add-oferta', [ProductController::class, 'addOferta'])->name('product.addOferta');
Route::post('producto/delete-oferta', [ProductController::class, 'deleteOferta'])->name('product.deleteOferta');

Route::get('productos/getProductByProveedor', [ProductController::class, 'getProductByProveedor'])->name('products.getProductByProveedor');

Route::get('importar', [ProductController::class, 'importFromCsv'])->name('import.products');

Route::get('productos/imprimir', [PrintController::class, 'printProductsPDF'])->name('products.printPDF');

Route::get('productos/exportar', [ProductController::class, 'exportProductsToCsv'])->name('products.exportCSV');
Route::get('productos/comparar/stock', [ProductController::class, 'compararStock'])->name('products.compararStock');

Route::get('productos/comparar/stock/print', [ProductController::class, 'printCompararStock'])->name('products.printCompararStock');

Route::get('productos-presentaciones/exportar', [ProductController::class, 'exportPresentacionesToCsv'])->name('products.exportPresentacionesCSV');
Route::get('productos-descuentos/exportar', [ProductController::class, 'exportDescuentosToCsv'])->name('products.exportDescuentosCSV');

Route::get('productos/importar/movimientos', [ProductController::class, 'importProductsMovement'])->name('products.importMovement');
Route::get('producto/ajuste-stock', [ProductController::class, 'getDataStock'])->name('getData.stock');
Route::post('producto/ajustar-stock', [ProductController::class, 'ajustarStock'])->name('ajustar.stock');

Route::get('producto/historial/{id?}', [ProductController::class, 'historial'])->middleware('can:products.edit')->name('product.historial');
Route::get('producto/print-historial', [ProductController::class, 'printHistorial'])->middleware('can:products.edit')->name('product.printHistorial');

Route::get('stock-de-productos', [ProductController::class, 'listByStocks'])->name('products.by.stocks');
Route::post('producto/ajustar-por-stock', [ProductController::class, 'ajustarByStock'])->name('ajustar.by.stock');

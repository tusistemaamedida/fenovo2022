<?php

use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('productos', [ProductController::class, 'list'])->name('products.list');

Route::get('productos/add', [ProductController::class, 'add'])->middleware('can:products.create')->name('product.add');
Route::post('productos/store', [ProductController::class, 'store'])->name('product.store');

Route::get('product-validate-code', [ProductController::class, 'validateCode'])->name('product.validate.code');
Route::get('calculate-product-prices', [ProductController::class, 'calculateProductPrices'])->name('calculate.product.prices');

Route::post('productos/destroy', [ProductController::class, 'destroy'])->middleware('can:products.edit')->name('product.destroy');

Route::get('producto/edit/{fecha_actualizacion?}', [ProductController::class, 'edit'])->middleware('can:products.edit')->name('product.edit');
Route::post('producto/update', [ProductController::class, 'update'])->name('product.update');
Route::post('producto/actualizar-precios', [ProductController::class, 'updatePrices'])->name('actualizar.precios');
Route::post('producto/actualizar-oferta', [ProductController::class, 'updateOferta'])->name('actualizar.oferta');

Route::post('producto/add-oferta', [ProductController::class, 'addOferta'])->name('product.addOferta');
Route::post('producto/delete-oferta', [ProductController::class, 'deleteOferta'])->name('product.deleteOferta');

Route::get('productos/getProductByProveedor', [ProductController::class, 'getProductByProveedor'])->name('products.getProductByProveedor');

Route::get('importar', [ProductController::class, 'importFromCsv'])->name('import.products');

Route::get('productos/exportar', [PrintController::class, 'exportProductsToCsv'])->name('products.exportCSV');
Route::get('productos/imprimir', [PrintController::class, 'printProductsPDF'])->name('products.printPDF');

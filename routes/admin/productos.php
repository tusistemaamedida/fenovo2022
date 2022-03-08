<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('productos', [ProductController::class, 'list'])->name('products.list');

Route::get('productos/add', [ProductController::class, 'add'])->middleware('can:products.create')->name('product.add');
Route::post('productos/store', [ProductController::class, 'store'])->name('product.store');

Route::get('product-validate-code', [ProductController::class, 'validateCode'])->name('product.validate.code');
Route::get('calculate-product-prices', [ProductController::class, 'calculateProductPrices'])->name('calculate.product.prices');

Route::post('productos/destroy', [ProductController::class, 'destroy'])->middleware('can:products.edit')->name('product.destroy');

Route::get('producto/edit', [ProductController::class, 'edit'])->middleware('can:products.edit')->name('product.edit');
Route::post('producto/update', [ProductController::class, 'update'])->name('product.update');

Route::get('productos/getProductByProveedor', [ProductController::class, 'getProductByProveedor'])->name('products.getProductByProveedor');

Route::get('importar', [ProductController::class, 'importFromCsv'])->name('import.products');
Route::get('exportar', [ProductController::class, 'exportToCsv'])->name('export.products');

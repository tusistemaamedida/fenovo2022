<?php

use App\Http\Controllers\Admin\ProductController;

Route::get('products', [ProductController::class, 'list'])->name('products.list');
Route::get('product-add', [ProductController::class, 'add'])->name('product.add');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('product-validate-code', [ProductController::class, 'validateCode'])->name('product.validate.code');
Route::get('calculate-product-prices', [ProductController::class, 'calculateProductPrices'])->name('calculate.product.prices');

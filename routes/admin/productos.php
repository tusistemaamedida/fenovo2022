<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('productos', [ProductController::class, 'list'])->name('products.list');
Route::get('productos/add', [ProductController::class, 'add'])->name('product.add');
Route::get('product-validate-code', [ProductController::class, 'validateCode'])->name('product.validate.code');
Route::get('calculate-product-prices', [ProductController::class, 'calculateProductPrices'])->name('calculate.product.prices');
Route::post('productos/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('productos/getProductByProveedor', [ProductController::class, 'getProductByProveedor'])->name('products.getProductByProveedor');

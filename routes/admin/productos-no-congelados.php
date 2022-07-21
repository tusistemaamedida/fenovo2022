<?php

use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\ProductNoCongeladosController;

use Illuminate\Support\Facades\Route;

Route::get('productos-no-congelados',        [ProductNoCongeladosController::class, 'list'])->name('products.nc.list');
Route::get('productos-no-congelados/edit',   [ProductNoCongeladosController::class, 'edit'])->name('product.nc.edit');
Route::post('productos-no-congelados/update', [ProductNoCongeladosController::class, 'update'])->name('product.nc.update');

Route::get('productos-no-congelados/index',  [ProductNoCongeladosController::class, 'index'])->name('products.nc.index');
Route::get('productos-no-congelados/add',    [ProductNoCongeladosController::class, 'add'])->name('product.nc.add');
Route::post('productos-no-congelados/store', [ProductNoCongeladosController::class, 'store'])->name('product.nc.store');

Route::get('productos-no-congelados/ver/{id?}', [ProductController::class, 'ver'])->name('product.nc.ver');

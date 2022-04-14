<?php

use App\Http\Controllers\Api\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('getProductos', [ProductController::class, 'getProductos'])->name('api.getProductos');
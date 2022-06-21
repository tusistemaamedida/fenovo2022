<?php

use App\Http\Controllers\Api\ProductoController;

use Illuminate\Support\Facades\Route;

Route::get('getProductos', [ProductoController::class, 'getProductos'])->name('api.getProductos');
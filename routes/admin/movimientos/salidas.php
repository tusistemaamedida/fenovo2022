<?php

use App\Http\Controllers\Admin\Movimientos\SalidasController;
use Illuminate\Support\Facades\Route;

// Salidas search.products
Route::get('salidas/add', [SalidasController::class, 'add'])->name('salidas.add');
Route::get('clientes/salidas', [SalidasController::class, 'getClienteSalida'])->name('get.cliente.salida');
Route::get('search-products', [SalidasController::class, 'searchProducts'])->name('search.products');

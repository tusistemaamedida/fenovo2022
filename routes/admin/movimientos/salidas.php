<?php

use App\Http\Controllers\Admin\Movimientos\SalidasController;
use Illuminate\Support\Facades\Route;

// Salidas
Route::get('salidas/add', [SalidasController::class, 'add'])->name('ingresos.add');

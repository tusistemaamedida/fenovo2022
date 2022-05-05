<?php

use App\Http\Controllers\Admin\Movimientos\NotasDebitoController;
use Illuminate\Support\Facades\Route;

// Salidas
Route::get('notas-de-debito', [NotasDebitoController::class, 'index'])->name('nd.index');
Route::get('notas-de-debito/add', [NotasDebitoController::class, 'add'])->name('nd.add');
Route::get('notas-de-debito/show', [NotasDebitoController::class, 'show'])->name('nd.show');
Route::post('guardar-nota-de-debito', [NotasDebitoController::class, 'storeNotaDebito'])->name('guardar.nd');

<?php

use App\Http\Controllers\Admin\DescuentoController;
use Illuminate\Support\Facades\Route;

Route::get('descuento', [DescuentoController::class, 'index'])->name('descuento.index');
Route::get('descuento/add', [DescuentoController::class, 'add'])->name('descuento.add');
Route::post('descuento/store', [DescuentoController::class, 'store'])->name('descuento.store');
Route::get('descuento/edit', [DescuentoController::class, 'edit'])->name('descuento.edit');
Route::post('descuento/update', [DescuentoController::class, 'update'])->name('descuento.update');
Route::post('descuento/destroy', [DescuentoController::class, 'destroy'])->name('descuento.destroy');

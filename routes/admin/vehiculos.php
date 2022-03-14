<?php

use App\Http\Controllers\Admin\VehiculoController;
use Illuminate\Support\Facades\Route;

Route::get('vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
Route::get('vehiculos/add', [VehiculoController::class, 'add'])->name('vehiculos.add');
Route::post('vehiculos/store', [VehiculoController::class, 'store'])->name('vehiculos.store');
Route::get('vehiculos/edit', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
Route::post('vehiculos/update', [VehiculoController::class, 'update'])->name('vehiculos.update');
Route::post('vehiculos/destroy', [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

Route::get('vehiculos/getHabilitacion', [VehiculoController::class, 'getHabilitacion'])->name('vehiculos.getHabilitacion');

<?php

use App\Http\Controllers\Admin\ActualizacionController;
use Illuminate\Support\Facades\Route;

Route::get('actualizacion', [ActualizacionController::class, 'index'])->name('actualizacion.index');
Route::get('actualizacion/add', [ActualizacionController::class, 'add'])->name('actualizacion.add');
Route::post('actualizacion/store', [ActualizacionController::class, 'store'])->name('actualizacion.store');
Route::get('actualizacion/edit', [ActualizacionController::class, 'edit'])->name('actualizacion.edit');
Route::post('actualizacion/update', [ActualizacionController::class, 'update'])->name('actualizacion.update');
Route::post('actualizacion/destroy', [ActualizacionController::class, 'destroy'])->name('actualizacion.destroy');

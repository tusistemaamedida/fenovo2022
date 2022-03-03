<?php

use App\Http\Controllers\Admin\RutasController;
use Illuminate\Support\Facades\Route;

Route::get('rutas', [RutasController::class, 'index'])->name('rutas.index');
Route::get('rutas/add', [RutasController::class, 'add'])->name('rutas.add');
Route::post('rutas/store', [RutasController::class, 'store'])->name('rutas.store');
Route::get('rutas/edit', [RutasController::class, 'edit'])->name('rutas.edit');
Route::post('rutas/update', [RutasController::class, 'update'])->name('rutas.update');
Route::post('rutas/destroy', [RutasController::class, 'destroy'])->name('rutas.destroy');

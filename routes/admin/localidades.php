<?php

use App\Http\Controllers\Admin\LocalidadesController;
use Illuminate\Support\Facades\Route;

Route::get('localidades', [LocalidadesController::class, 'index'])->name('localidades.index');
Route::get('localidades/add', [LocalidadesController::class, 'add'])->name('localidades.add');
Route::post('localidades/store', [LocalidadesController::class, 'store'])->name('localidades.store');
Route::get('localidades/edit', [LocalidadesController::class, 'edit'])->name('localidades.edit');
Route::post('localidades/update', [LocalidadesController::class, 'update'])->name('localidades.update');
Route::post('localidades/destroy', [LocalidadesController::class, 'destroy'])->name('localidades.destroy');

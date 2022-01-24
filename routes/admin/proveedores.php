<?php

use App\Http\Controllers\Admin\ProveedorController;
use Illuminate\Support\Facades\Route;

Route::get('proveedors', [ProveedorController::class, 'index'])->name('proveedors.index');
Route::get('proveedors/add', [ProveedorController::class, 'add'])->name('proveedors.add');
Route::post('proveedors/store', [ProveedorController::class, 'store'])->name('proveedors.store');
Route::get('proveedors/edit', [ProveedorController::class, 'edit'])->name('proveedors.edit');
Route::post('proveedors/update', [ProveedorController::class, 'update'])->name('proveedors.update');
Route::post('proveedors/destroy', [ProveedorController::class, 'destroy'])->name('proveedors.destroy');

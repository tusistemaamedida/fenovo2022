<?php

use App\Http\Controllers\Admin\ProveedorController;
use Illuminate\Support\Facades\Route;

Route::get('proveedores', [ProveedorController::class, 'index'])->name('proveedors.index');
Route::get('proveedores/add', [ProveedorController::class, 'add'])->name('proveedors.add');
Route::post('proveedores/store', [ProveedorController::class, 'store'])->name('proveedors.store');
Route::get('proveedores/edit', [ProveedorController::class, 'edit'])->name('proveedors.edit');
Route::post('proveedores/update', [ProveedorController::class, 'update'])->name('proveedors.update');
Route::post('proveedores/destroy', [ProveedorController::class, 'destroy'])->name('proveedors.destroy');

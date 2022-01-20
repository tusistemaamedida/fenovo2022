<?php

use App\Http\Controllers\Admin\ProveedorController;

Route::get('proveedors', [ProveedorController::class, 'list'])->name('proveedors.list');
Route::get('proveedors/add', [ProveedorController::class, 'add'])->name('proveedors.add');
Route::post('proveedors/store', [ProveedorController::class, 'store'])->name('proveedors.store');
Route::get('proveedors/edit', [ProveedorController::class, 'edit'])->name('proveedors.edit');
Route::post('proveedors/update', [ProveedorController::class, 'update'])->name('proveedors.update');
Route::delete('proveedors/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedors.destroy');

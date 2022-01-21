<?php

use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('permissions/add', [PermissionController::class, 'add'])->name('permissions.add');
Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
Route::post('permissions/destroy', [PermissionController::class, 'destroy'])->name('permissions.destroy');

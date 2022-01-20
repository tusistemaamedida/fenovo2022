<?php

use App\Http\Controllers\Admin\PermissionController;

Route::get('permissions', [PermissionController::class, 'list'])->name('permissions.list');
Route::get('permissions/add', [PermissionController::class, 'add'])->name('permissions.add');
Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

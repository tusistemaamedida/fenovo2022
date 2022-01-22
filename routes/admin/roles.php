<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;

Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('roles/add', [RoleController::class, 'add'])->name('roles.add');
Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::get('roles/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::post('roles/update', [RoleController::class, 'update'])->name('roles.update');
Route::post('roles/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

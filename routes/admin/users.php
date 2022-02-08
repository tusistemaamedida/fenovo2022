<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('user/add', [UserController::class, 'add'])->name('users.add');
Route::post('user/store', [UserController::class, 'store'])->name('users.store');
Route::get('users/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('users/update', [UserController::class, 'update'])->name('users.update');
Route::post('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('users/edit-profile', [UserController::class, 'editProfile'])->name('users.editProfile');

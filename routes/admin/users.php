<?php

use App\Http\Controllers\Admin\UserController;

Route::get('users', [UserController::class, 'list'])->name('users.list');
Route::get('user/add', [UserController::class, 'add'])->name('users.add');
Route::post('user/store', [UserController::class, 'store'])->name('users.store');
Route::get('users/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('users/update', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

<?php

use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('stores/add', [StoreController::class, 'add'])->name('stores.add');
Route::post('stores/store', [StoreController::class, 'store'])->name('stores.store');
Route::get('stores/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::post('stores/update', [StoreController::class, 'update'])->name('stores.update');
Route::post('stores/destroy', [StoreController::class, 'destroy'])->name('stores.destroy');

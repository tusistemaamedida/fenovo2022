<?php

use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('tiendas', [StoreController::class, 'index'])->name('stores.index');
Route::get('tiendas/add', [StoreController::class, 'add'])->name('stores.add');
Route::post('tiendas/store', [StoreController::class, 'store'])->name('stores.store');
Route::get('tiendas/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::post('tiendas/update', [StoreController::class, 'update'])->name('stores.update');
Route::post('tiendas/destroy', [StoreController::class, 'destroy'])->name('stores.destroy');

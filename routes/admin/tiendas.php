<?php

use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('tiendas', [StoreController::class, 'index'])->name('stores.index');
Route::get('tiendas/add', [StoreController::class, 'add'])->name('stores.add');
Route::post('tiendas/store', [StoreController::class, 'store'])->name('stores.store');
Route::get('tiendas/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::post('tiendas/update', [StoreController::class, 'update'])->name('stores.update');
Route::post('tiendas/destroy', [StoreController::class, 'destroy'])->name('stores.destroy');

Route::get('depositos', [StoreController::class, 'index'])->name('depositos.index');
Route::get('depositos/add', [StoreController::class, 'addDeposito'])->name('depositos.add');
Route::post('depositos/store', [StoreController::class, 'storeDeposito'])->name('depositos.store');
Route::get('depositos/edit', [StoreController::class, 'editDeposito'])->name('depositos.edit');
Route::post('depositos/update', [StoreController::class, 'updateDeposito'])->name('depositos.update');
Route::post('depositos/destroy', [StoreController::class, 'destroyDeposito'])->name('depositos.destroy');

<?php

use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\DepositosController;
use Illuminate\Support\Facades\Route;

Route::get('tiendas', [StoreController::class, 'index'])->name('stores.index');
Route::get('tiendas/add', [StoreController::class, 'add'])->name('stores.add');
Route::post('tiendas/store', [StoreController::class, 'store'])->name('stores.store');
Route::get('tiendas/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::post('tiendas/update', [StoreController::class, 'update'])->name('stores.update');
Route::post('tiendas/destroy', [StoreController::class, 'destroy'])->name('stores.destroy');

Route::get('depositos', [DepositosController::class, 'index'])->name('depositos.index');
Route::get('depositos/add', [DepositosController::class, 'add'])->name('depositos.add');
Route::post('depositos/store', [DepositosController::class, 'store'])->name('depositos.store');
Route::get('depositos/edit', [DepositosController::class, 'edit'])->name('depositos.edit');
Route::post('depositos/update', [DepositosController::class, 'update'])->name('depositos.update');
Route::post('depositos/destroy', [DepositosController::class, 'destroy'])->name('depositos.destroy');

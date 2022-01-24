<?php

use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('customers/add', [CustomerController::class, 'add'])->name('customers.add');
Route::post('customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('customers/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::post('customers/update', [CustomerController::class, 'update'])->name('customers.update');
Route::post('customers/destroy', [CustomerController::class, 'destroy'])->name('customers.destroy');

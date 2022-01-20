<?php

use App\Http\Controllers\Admin\CustomerController;

Route::get('customers', [CustomerController::class, 'list'])->name('customers.list');
Route::get('customers/add', [CustomerController::class, 'add'])->name('customers.add');
Route::post('customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('customers/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::post('customers/update', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

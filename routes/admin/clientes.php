<?php

use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('clientes', [CustomerController::class, 'index'])->name('customers.index');
Route::get('clientes/add', [CustomerController::class, 'add'])->name('customers.add');
Route::post('clientes/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('clientes/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::post('clientes/update', [CustomerController::class, 'update'])->name('customers.update');
Route::post('clientes/destroy', [CustomerController::class, 'destroy'])->name('customers.destroy');

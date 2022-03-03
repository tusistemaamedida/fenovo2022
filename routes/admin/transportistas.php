<?php

use App\Http\Controllers\Admin\TransportistaController;
use Illuminate\Support\Facades\Route;

Route::get('transportistas', [TransportistaController::class, 'index'])->name('transportistas.index');
Route::get('transportistas/add', [TransportistaController::class, 'add'])->name('transportistas.add');
Route::post('transportistas/store', [TransportistaController::class, 'store'])->name('transportistas.store');
Route::get('transportistas/edit', [TransportistaController::class, 'edit'])->name('transportistas.edit');
Route::post('transportistas/update', [TransportistaController::class, 'update'])->name('transportistas.update');
Route::post('transportistas/destroy', [TransportistaController::class, 'destroy'])->name('transportistas.destroy');

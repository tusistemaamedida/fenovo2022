<?php

use App\Http\Controllers\Admin\OfertaController;
use Illuminate\Support\Facades\Route;

Route::get('oferta', [OfertaController::class, 'index'])->name('oferta.index');
Route::get('oferta/add', [OfertaController::class, 'add'])->name('oferta.add');
Route::post('oferta/store', [OfertaController::class, 'store'])->name('oferta.store');
Route::get('oferta/edit', [OfertaController::class, 'edit'])->name('oferta.edit');
Route::post('oferta/update', [OfertaController::class, 'update'])->name('oferta.update');
Route::post('oferta/destroy', [OfertaController::class, 'destroy'])->name('oferta.destroy');

<?php

use App\Http\Controllers\Admin\Movimientos\SenasaController;
use Illuminate\Support\Facades\Route;

// Senasa
Route::get('senasa', [SenasaController::class, 'index'])->name('senasa.index');
Route::get('senasa/add', [SenasaController::class, 'add'])->name('senasa.add');
Route::post('senasa/store', [SenasaController::class, 'store'])->name('senasa.store');
Route::get('senasa/edit', [SenasaController::class, 'edit'])->name('senasa.edit');
Route::post('senasa/update', [SenasaController::class, 'update'])->name('senasa.update');
Route::delete('senasa/destroy', [SenasaController::class, 'destroy'])->name('senasa.destroy');

Route::get('senasa/print', [SenasaController::class, 'print'])->name('senasa.print');
Route::get('senasa/vincular', [SenasaController::class, 'vincular'])->name('senasa.vincular');
Route::post('senasa/vincular-store', [SenasaController::class, 'vincularStore'])->name('senasa.vincularStore');
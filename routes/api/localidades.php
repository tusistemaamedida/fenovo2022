<?php

use App\Http\Controllers\Api\LocalidadController;

use Illuminate\Support\Facades\Route;

Route::get('getLocalidades', [LocalidadController::class, 'getLocalidades'])->name('api.getLocalidades');
Route::get('createLocalidad', [LocalidadController::class, 'createLocalidad'])->name('api.createLocalidad');
Route::post('storeLocalidad/', [LocalidadController::class, 'storeLocalidad'])->name('api.storeLocalidad');
Route::get('editLocalidad/{id}', [LocalidadController::class, 'editLocalidad'])->name('api.editLocalidad');
Route::delete('destroyLocalidad/{id}', [LocalidadController::class, 'destroyLocalidad'])->name('api.destroyLocalidad');

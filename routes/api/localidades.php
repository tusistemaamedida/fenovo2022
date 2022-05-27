<?php

use App\Http\Controllers\Api\LocalidadController;

use Illuminate\Support\Facades\Route;

Route::get('getLocalidades', [LocalidadController::class, 'getLocalidades'])->name('api.getLocalidades');
Route::post('storeLocalidad/', [LocalidadController::class, 'storeLocalidad'])->name('api.storeLocalidad');
Route::put('updateLocalidad/{id}', [LocalidadController::class, 'updateLocalidad'])->name('api.updateLocalidad');
Route::delete('destroyLocalidad/{id}', [LocalidadController::class, 'destroyLocalidad'])->name('api.destroyLocalidad');

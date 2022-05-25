<?php

use App\Http\Controllers\Api\LocalidadController;

use Illuminate\Support\Facades\Route;

Route::get('getLocalidades', [LocalidadController::class, 'getLocalidades'])->name('api.getLocalidades');

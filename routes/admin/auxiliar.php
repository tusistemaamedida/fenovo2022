<?php

use App\Http\Controllers\AuxController;
use Illuminate\Support\Facades\Route;

Route::get('actualizar-list-id', [AuxController::class, 'updateListId']);

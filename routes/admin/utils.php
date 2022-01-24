<?php

use App\Http\Controllers\Admin\UtilsController;
use Illuminate\Support\Facades\Route;

Route::get('clean', [UtilsController::class, 'clean'])->name('clean');

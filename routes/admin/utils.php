<?php

use App\Http\Controllers\Admin\UtilsController;

Route::get('clean', [UtilsController::class, 'clean'])->name('clean');

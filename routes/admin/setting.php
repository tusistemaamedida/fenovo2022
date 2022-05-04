<?php
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('setting', [SettingController::class, 'index'])->name('setting.index');

<?php
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('setting/index', [SettingController::class, 'index'])->name('seeting.index');

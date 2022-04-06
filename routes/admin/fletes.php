<?php

use App\Http\Controllers\Admin\FleteSettingController;
use Illuminate\Support\Facades\Route;

Route::get('fletes', [FleteSettingController::class, 'index'])->name('fletes.index');
Route::get('fletes/add', [FleteSettingController::class, 'add'])->name('fletes.add');
Route::post('fletes/store', [FleteSettingController::class, 'store'])->name('fletes.store');
Route::get('fletes/edit', [FleteSettingController::class, 'edit'])->name('fletes.edit');
Route::post('fletes/update', [FleteSettingController::class, 'update'])->name('fletes.update');
Route::post('fletes/destroy', [FleteSettingController::class, 'destroy'])->name('fletes.destroy');

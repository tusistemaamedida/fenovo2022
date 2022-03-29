<?php

use App\Http\Controllers\Admin\SenasaDefinitionController;
use Illuminate\Support\Facades\Route;

Route::get('senasa-definition', [SenasaDefinitionController::class, 'index'])->name('senasa-definition.index');
Route::get('senasa-definition/add', [SenasaDefinitionController::class, 'add'])->name('senasa-definition.add');
Route::post('senasa-definition/store', [SenasaDefinitionController::class, 'store'])->name('senasa-definition.store');
Route::get('senasa-definition/edit', [SenasaDefinitionController::class, 'edit'])->name('senasa-definition.edit');
Route::post('senasa-definition/update', [SenasaDefinitionController::class, 'update'])->name('senasa-definition.update');
Route::post('senasa-definition/destroy', [SenasaDefinitionController::class, 'destroy'])->name('senasa-definition.destroy');

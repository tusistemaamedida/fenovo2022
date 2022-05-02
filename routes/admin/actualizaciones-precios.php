<?php

use App\Http\Controllers\Admin\ActualizacionController;
use Illuminate\Support\Facades\Route;

Route::get('actualizacion', [ActualizacionController::class, 'index'])->name('actualizacion.index');
Route::get('actualizacion/historial', [ActualizacionController::class, 'historial'])->name('actualizacion.historial');

Route::get('actualizacion/add', [ActualizacionController::class, 'add'])->name('actualizacion.add');
Route::post('actualizacion/store', [ActualizacionController::class, 'store'])->name('actualizacion.store');
Route::get('actualizacion/edit', [ActualizacionController::class, 'edit'])->name('actualizacion.edit');
Route::get('actualizacion/update', [ActualizacionController::class, 'update'])->name('actualizacion.update');
Route::post('actualizacion/destroy', [ActualizacionController::class, 'destroy'])->name('actualizacion.destroy');

Route::get('actualizacion/exportar', [ActualizacionController::class, 'exportToCsv'])->name('actualizacion.exportCSV');
Route::get('actualizacion/exportarM1', [ActualizacionController::class, 'exportToCsvM1'])->name('actualizacion.exportCSVM1');
Route::get('actualizacion/exportarM2', [ActualizacionController::class, 'exportToCsvM2'])->name('actualizacion.exportCSVM2');


Route::get('exportar/cabe-ped', [ActualizacionController::class, 'exportCabePed'])->name('export.cabePed');
Route::get('exportar/cabe-ele', [ActualizacionController::class, 'exportCabeEle'])->name('export.cabeEle');

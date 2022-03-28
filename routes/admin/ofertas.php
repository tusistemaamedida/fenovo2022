<?php

use App\Http\Controllers\Admin\OfertaController;
use Illuminate\Support\Facades\Route;

Route::get('oferta', [OfertaController::class, 'index'])->name('oferta.index');
Route::get('oferta/excepciones', [OfertaController::class, 'excepciones'])->name('oferta.excepciones');


Route::get('oferta/add', [OfertaController::class, 'add'])->name('oferta.add');
Route::post('oferta/store', [OfertaController::class, 'store'])->name('oferta.store');
Route::get('oferta/edit', [OfertaController::class, 'edit'])->name('oferta.edit');
Route::post('oferta/update', [OfertaController::class, 'update'])->name('oferta.update');
Route::post('oferta/destroy', [OfertaController::class, 'destroy'])->name('oferta.destroy');
Route::post('oferta/destroyReload', [OfertaController::class, 'destroyReload'])->name('oferta.destroyReload');


Route::get('oferta/vincular-tienda', [OfertaController::class, 'vincularTienda'])->name('oferta.vincular.tienda');
Route::post('oferta/vincular-tienda', [OfertaController::class, 'vincularTiendaUpdate'])->name('oferta.vincular.tienda.update');

Route::get('oferta/exportar', [OfertaController::class, 'exportToCsv'])->name('oferta.exportCSV');
Route::get('oferta/exportar/excepciones', [OfertaController::class, 'exportExcepcionesToCsv'])->name('oferta.excepciones.exportCSV');


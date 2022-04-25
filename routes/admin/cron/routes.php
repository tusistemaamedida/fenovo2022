<?php


use App\Http\Controllers\Cron\StockSummaryController;
use App\Http\Controllers\Cron\ActualizacionPrecios;
use Illuminate\Support\Facades\Route;

Route::get('iniciar-conteo-de-stock', [StockSummaryController::class, 'init'])->name('init.stock.cummary');
Route::get('actualizacion-precios-programada', [ActualizacionPrecios::class, 'init'])->name('init.update.prices');

<?php


use App\Http\Controllers\Cron\StockSummaryController;
use Illuminate\Support\Facades\Route;

Route::get('iniciar-conteo-de-stock', [StockSummaryController::class, 'init'])->name('init.stock.cummary');

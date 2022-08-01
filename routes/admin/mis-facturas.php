<?php

use App\Http\Controllers\MisFacturasController;
use Illuminate\Support\Facades\Route;

Route::get('tiendas/mis-facturas', [MisFacturasController::class, 'inicio'])->name('mis.facturas');
Route::post('tiendas/mis-facturas/check', [MisFacturasController::class, 'check'])->name('mis.facturas.check');
Route::get('tiendas/mis-facturas/list', [MisFacturasController::class, 'list'])->name('mis.facturas.list');

Route::get('tiendas/mis-facturas/edit', [MisFacturasController::class, 'editPassword'])->name('mis.facturas.edit.password');
Route::post('tiendas/mis-facturas/update', [MisFacturasController::class, 'updatePassword'])->name('mis.facturas.update.password');

Route::get('tiendas/imprimir/papers/', [MisFacturasController::class, 'printPanama'])->name('tiendas.print.panama');
Route::get('tiendas/imprimir/flete/', [MisFacturasController::class, 'printPanamaFlete'])->name('tiendas.print.flete');

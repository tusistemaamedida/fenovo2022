<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MisFacturasController;

Route::get('tiendas/mis-facturas', [MisFacturasController::class, 'inicio'])->name('mis.facturas');
Route::get('tiendas/mis-facturas/list/', [MisFacturasController::class, 'getMisFacturasList'])->name('get.mis.facturas.list');
Route::post('tiendas/mis-facturas/', [MisFacturasController::class, 'getMisFacturas'])->name('get.mis.facturas');
Route::get('tiendas/mis-facturas/edit', [MisFacturasController::class, 'editPassword'])->name('mis.facturas.edit.password');
Route::post('tiendas/mis-facturas/update', [MisFacturasController::class, 'updatePassword'])->name('mis.facturas.update.password');

Route::get('tiendas/imprimir/papers/', [MisFacturasController::class, 'printPanama'])->name('tiendas.print.panama');
Route::get('tiendas/imprimir/flete/', [MisFacturasController::class, 'printPanamaFlete'])->name('tiendas.print.flete');
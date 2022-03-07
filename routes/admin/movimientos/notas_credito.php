<?php

use App\Http\Controllers\Admin\Movimientos\NotasCreditoController;
use Illuminate\Support\Facades\Route;

// Salidas
Route::get('notas-de-credito', [NotasCreditoController::class, 'index'])->name('nc.index');
Route::get('notas-de-credito/add', [NotasCreditoController::class, 'add'])->name('nc.add');
Route::get('notas-de-credito/show', [NotasCreditoController::class, 'show'])->name('nc.show');
Route::get('buscar-numero-factura', [NotasCreditoController::class, 'searchVoucherNumber'])->name('search.voucher_number');
Route::post('guardar-nota-de-credito', [NotasCreditoController::class, 'storeNotaCredito'])->name('guardar.nc');
Route::get('validar-nro-factura-con-tienda-salida', [NotasCreditoController::class, 'validateVoucherTo'])->name('validate.voucher.to');

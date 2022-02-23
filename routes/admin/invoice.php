<?php

use App\Http\Controllers\Admin\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('facturas-generadas', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('crear-factura/{movment_id}', [InvoiceController::class, 'create'])->name('create.invoice');

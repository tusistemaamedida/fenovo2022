<?php

use App\Http\Controllers\Admin\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('afip-crear-factura', [InvoiceController::class, 'create'])->name('create.invoice');

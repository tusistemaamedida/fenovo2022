<?php

use App\Http\Controllers\Admin\FilepickerController;
use App\Http\Controllers\Admin\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'preventBackHistory'], function () {
    Route::get('/', function () {
        return view('auth.login');
    });

    Auth::routes();
    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio');

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
        require __DIR__ . '/admin/productos.php';
        require __DIR__ . '/admin/tiendas.php';
        require __DIR__ . '/admin/clientes.php';
        require __DIR__ . '/admin/proveedores.php';
        require __DIR__ . '/admin/users.php';
        require __DIR__ . '/admin/roles.php';
        require __DIR__ . '/admin/permissions.php';
        require __DIR__ . '/admin/utils.php';
        require __DIR__ . '/admin/invoice.php';
        // Movimientos
        require __DIR__ . '/admin/movimientos/ingresos.php';
        require __DIR__ . '/admin/movimientos/salidas.php';
        require __DIR__ . '/admin/movimientos/senasa.php';
    });
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::any('filepicker', [FilepickerController::class, 'handle'])->name('filepicker');
});


Route::get('factura-electronica/{movment_id}', [InvoiceController::class, 'generateInvoicePdf'])->name('ver.fe');
//require __DIR__ . '/cron/routes.php';

<?php

use App\Http\Controllers\Admin\FilepickerController;
use App\Http\Controllers\Admin\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portada');
});

Route::group(['middleware' => 'preventBackHistory'], function () {
    Auth::routes();
    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio');

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
        require __DIR__ . '/admin/productos.php';
        require __DIR__ . '/api/productos.php';
        require __DIR__ . '/admin/actualizaciones-precios.php';
        require __DIR__ . '/admin/senasa-definitions.php';
        require __DIR__ . '/admin/descuentos.php';
        require __DIR__ . '/admin/ofertas.php';
        require __DIR__ . '/admin/tiendas.php';
        require __DIR__ . '/admin/clientes.php';
        require __DIR__ . '/admin/proveedores.php';
        require __DIR__ . '/admin/users.php';
        require __DIR__ . '/admin/roles.php';
        require __DIR__ . '/admin/permissions.php';
        require __DIR__ . '/admin/utils.php';
        require __DIR__ . '/admin/invoice.php';
        require __DIR__ . '/admin/print.php';
        require __DIR__ . '/admin/mails.php';
        // Movimientos
        require __DIR__ . '/admin/movimientos/ingresos.php';
        require __DIR__ . '/admin/movimientos/salidas.php';
        require __DIR__ . '/admin/movimientos/notas_credito.php';
        require __DIR__ . '/admin/movimientos/senasa.php';
        // Logistica
        require __DIR__ . '/admin/transportistas.php';
        require __DIR__ . '/admin/vehiculos.php';
        require __DIR__ . '/admin/rutas.php';
        require __DIR__ . '/admin/fletes.php';
        //
        require __DIR__ . '/admin/localidades.php';
    });
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::any('filepicker', [FilepickerController::class, 'handle'])->name('filepicker');
});

Route::get('factura-electronica/{movment_id}', [InvoiceController::class, 'generateInvoicePdf'])->name('ver.fe');
require __DIR__ . '/admin/cron/routes.php';

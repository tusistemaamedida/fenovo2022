<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => 'preventBackHistory'], function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    Auth::routes();
    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio');

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
        Route::any('filepicker', [App\Http\Controllers\Admin\FilepickerController::class, 'handle'])->name('filepicker');;
        require __DIR__ . '/admin/productos.php';
        require __DIR__ . '/admin/tiendas.php';
        require __DIR__ . '/admin/clientes.php';
        require __DIR__ . '/admin/proveedores.php';
        require __DIR__ . '/admin/users.php';
        require __DIR__ . '/admin/roles.php';
        require __DIR__ . '/admin/permissions.php';
        require __DIR__ . '/admin/utils.php';
        // Movimientos
        require __DIR__ . '/admin/movimientos/ingresos.php';
    });
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::any('filepicker', [App\Http\Controllers\Admin\FilepickerController::class, 'handle'])->name('filepicker');;
});

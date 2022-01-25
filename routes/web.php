<?php

use App\Http\Controllers\Admin\FilepickerController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => 'preventBackHistory'], function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
        Route::any('filepicker', [FilepickerController::class, 'handle'])->name('filepicker');;
        require __DIR__ . '/admin/products.php';
        require __DIR__ . '/admin/stores.php';
        require __DIR__ . '/admin/customers.php';
        require __DIR__ . '/admin/users.php';
        require __DIR__ . '/admin/roles.php';
        require __DIR__ . '/admin/permissions.php';
        require __DIR__ . '/admin/proveedores.php';
        require __DIR__ . '/admin/utils.php';
    });
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::any('filepicker', [FilepickerController::class, 'handle'])->name('filepicker');;
});

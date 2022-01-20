<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    //dd(Hash::make('12345678'));
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::any('filepicker', [App\Http\Controllers\Admin\FilepickerController::class,'handle'])->name('filepicker');;
    require __DIR__ . '/admin/products.php';
    require __DIR__ . '/admin/stores.php';
    require __DIR__ . '/admin/customers.php';
    require __DIR__ . '/admin/users.php';
    require __DIR__ . '/admin/roles.php';
    require __DIR__ . '/admin/permissions.php';
    require __DIR__ . '/admin/proveedores.php';
});

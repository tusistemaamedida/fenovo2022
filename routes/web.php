<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    require __DIR__ . '/admin/products.php';
    require __DIR__ . '/admin/stores.php';
    require __DIR__ . '/admin/customers.php';
    require __DIR__ . '/admin/users.php';
    require __DIR__ . '/admin/roles.php';
    require __DIR__ . '/admin/permissions.php';
});

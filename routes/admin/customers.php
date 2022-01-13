<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class,'list'])->name('customers.list');
    });
?>

<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('products', [App\Http\Controllers\Admin\ProductController::class,'list'])->name('products.list');
    });
?>
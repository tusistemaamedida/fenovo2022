<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('products', [App\Http\Controllers\Admin\ProductController::class,'list'])->name('products.list');
        Route::get('product-add', [App\Http\Controllers\Admin\ProductController::class,'add'])->name('product.add');
        Route::get('calculate-product-prices', [App\Http\Controllers\Admin\ProductController::class,'calculateProductPrices'])->name('calculate.product.prices');
    });
?>

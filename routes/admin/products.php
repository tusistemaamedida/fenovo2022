<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('productos', [App\Http\Controllers\Admin\ProductController::class,'list'])->name('products.list');
    });
?>

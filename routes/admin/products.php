<?php
    Route::get('products', [App\Http\Controllers\Admin\ProductController::class,'list'])->name('products.list');
    Route::get('product-add', [App\Http\Controllers\Admin\ProductController::class,'add'])->name('product.add');
?>

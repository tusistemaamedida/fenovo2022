<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('stores', [App\Http\Controllers\Admin\StoreController::class,'list'])->name('stores.list');
    });
?>

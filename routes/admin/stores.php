<?php
    
    Route::get('stores', [App\Http\Controllers\Admin\StoreController::class,'list'])->name('stores.list');    
    Route::get('stores/edit', [App\Http\Controllers\Admin\StoreController::class,'edit'])->name('stores.edit');
    Route::post('stores/update', [App\Http\Controllers\Admin\StoreController::class,'update'])->name('stores.update');
?>
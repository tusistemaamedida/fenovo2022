<?php
    
    Route::get('stores', [App\Http\Controllers\Admin\StoreController::class,'list'])->name('stores.list');    
    Route::get('stores/edit/{id}', [App\Http\Controllers\Admin\StoreController::class,'edit'])->name('stores.edit');    
?>

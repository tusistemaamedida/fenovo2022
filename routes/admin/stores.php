<?php
    Route::get('stores', [App\Http\Controllers\Admin\StoreController::class,'list'])->name('stores.list');    
?>

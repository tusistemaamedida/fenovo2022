<?php
    Route::get('proveedors', [App\Http\Controllers\Admin\ProveedorController::class,'list'])->name('proveedors.list');
    Route::get('proveedors/edit/{id}', [App\Http\Controllers\Admin\ProveedorController::class,'edit'])->name('proveedors.edit');    
?>

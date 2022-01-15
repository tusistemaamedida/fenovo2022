<?php
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class,'list'])->name('permissions.list');
    Route::get('permissions/edit/{id}', [App\Http\Controllers\Admin\PermissionController::class,'edit'])->name('permissions.edit');    
?>

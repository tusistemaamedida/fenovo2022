<?php
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class,'list'])->name('permissions.list');
    Route::get('permissions/edit', [App\Http\Controllers\Admin\PermissionController::class,'edit'])->name('permissions.edit');
    Route::post('permissions/update', [App\Http\Controllers\Admin\PermissionController::class,'update'])->name('permissions.update');  
?>

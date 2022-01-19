<?php
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class,'list'])->name('permissions.list');
    Route::get('permissions/add', [App\Http\Controllers\Admin\PermissionController::class,'add'])->name('permissions.add');
    Route::post('permissions/store', [App\Http\Controllers\Admin\PermissionController::class,'store'])->name('permissions.store');  
    Route::get('permissions/edit', [App\Http\Controllers\Admin\PermissionController::class,'edit'])->name('permissions.edit');
    Route::post('permissions/update', [App\Http\Controllers\Admin\PermissionController::class,'update'])->name('permissions.update');  
?>

<?php
    Route::get('roles', [App\Http\Controllers\Admin\RoleController::class,'list'])->name('roles.list');
    Route::get('roles/edit', [App\Http\Controllers\Admin\RoleController::class,'edit'])->name('roles.edit');
    Route::post('roles/update', [App\Http\Controllers\Admin\RoleController::class,'update'])->name('roles.update');  
?>

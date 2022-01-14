<?php
    Route::get('roles', [App\Http\Controllers\Admin\RoleController::class,'list'])->name('roles.list');
    Route::get('roles/edit/{id}', [App\Http\Controllers\Admin\RoleController::class,'edit'])->name('roles.edit');    
?>

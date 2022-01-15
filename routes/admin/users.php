<?php
    Route::get('users', [App\Http\Controllers\Admin\UserController::class,'list'])->name('users.list');
    Route::get('users/edit/{id}', [App\Http\Controllers\Admin\UserController::class,'edit'])->name('users.edit');    
?>

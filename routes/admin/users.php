<?php
    Route::get('users', [App\Http\Controllers\Admin\UserController::class,'list'])->name('users.list');
    Route::get('users/edit', [App\Http\Controllers\Admin\UserController::class,'edit'])->name('users.edit');
    Route::post('users/update', [App\Http\Controllers\Admin\UserController::class,'update'])->name('users.update');
?>

<?php
    Route::get('users', [App\Http\Controllers\Admin\UserController::class,'list'])->name('users.list');    
?>

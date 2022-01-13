<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('users', [App\Http\Controllers\Admin\UserController::class,'list'])->name('users.list');
    });
?>

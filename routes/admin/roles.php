<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class,'list'])->name('roles.list');
    });
?>

<?php
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class,'list'])->name('permissions.list');
    });
?>

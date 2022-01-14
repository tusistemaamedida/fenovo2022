<?php
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class,'list'])->name('permissions.list');
?>

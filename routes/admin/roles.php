<?php
    Route::get('roles', [App\Http\Controllers\Admin\RoleController::class,'list'])->name('roles.list');
?>

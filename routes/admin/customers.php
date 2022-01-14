<?php 
    Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class,'list'])->name('customers.list');
    Route::get('customers/edit/{id}', [App\Http\Controllers\Admin\CustomerController::class,'edit'])->name('customers.edit');
?>

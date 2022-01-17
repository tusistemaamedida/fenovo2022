<?php 
    Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class,'list'])->name('customers.list');
    Route::get('customers/edit', [App\Http\Controllers\Admin\CustomerController::class,'edit'])->name('customers.edit');
    Route::post('customers/update', [App\Http\Controllers\Admin\CustomerController::class,'update'])->name('customers.update');  
?>
?>

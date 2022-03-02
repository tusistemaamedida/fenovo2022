<?php
use App\Http\Controllers\Admin\PrintController;
use Illuminate\Support\Facades\Route;

Route::get('movement-menu/print', [PrintController::class, 'menuPrint'])->name('movement.menu.print');
Route::get('movement-print/entreFechas', [PrintController::class, 'printEntreFechas'])->name('movement.printEntreFechas');
Route::get('movement-export/entreFechas', [PrintController::class, 'exportEntreFechas'])->name('movement.exportEntreFechas');



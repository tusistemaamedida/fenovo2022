<?php
use App\Http\Controllers\Admin\PrintController;
use Illuminate\Support\Facades\Route;

Route::get('menu/print', [PrintController::class, 'menuPrint'])->name('menu.print');
Route::get('movement-print/printPDF', [PrintController::class, 'printMovimientosPDF'])->name('movement.printPDF');
Route::get('movement-export/exportCSV', [PrintController::class, 'exportMovimientosCsv'])->name('movement.exportCSV');



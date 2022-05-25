<?php
use App\Http\Controllers\Admin\CiudadesController;
use Illuminate\Support\Facades\Route;

Route::get('ciudades', [CiudadesController::class, 'index'])->name('ciudades.index');

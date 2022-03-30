<?php

use App\Http\Controllers\Admin\MailController;
use Illuminate\Support\Facades\Route;

Route::get('mail/enviar', [MailController::class, 'enviar'])->name('mail.enviar');

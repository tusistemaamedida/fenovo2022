<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NovedadMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class MailController extends Controller
{
    public function enviar()
    {
        Mail::to('novedades@frioteka.com')
        ->bcc('cachoalbornoz@gmail.com')
        ->send(new NovedadMail('oferta de precios'));
    }
}

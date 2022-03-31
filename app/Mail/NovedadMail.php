<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NovedadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $novedad;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($novedad)
    {
        $this->novedad = $novedad;
        $this->user = Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Novedades Fenovo')->view('emails.NovedadEmail');
    }
}

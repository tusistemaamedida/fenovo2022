<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class LoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user             = $event->user;
        $last_login       = $user->last_login;
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();
        FacadesSession::flash('login-success', 'Bienvenido <strong>' . $event->user->name . '</strong> ! Último acceso <strong>'.date('d-m-Y H:i:s',strtotime($last_login)).'</strong>');
    }
}

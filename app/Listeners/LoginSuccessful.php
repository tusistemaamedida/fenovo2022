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
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        $stores = $user->stores();

        //FacadesSession::flash('login-success', $stores);
        FacadesSession::flash('login-success', 'Hola <strong>' . $event->user->name . ', </strong> bienvenido nuevamente !');
    }
}

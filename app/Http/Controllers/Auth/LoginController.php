<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/inicio';

    public function authenticated($request, $user)
    {
        if (Auth::user()->rol() == 'base') {
            $this->guard()->logout();
            $request->session()->invalidate();
            Session::flash('role-error', 'Acceso <strong>restringido </strong>');
            return $this->loggedOut($request) ?: redirect('/login');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                $this->username()    => 'required|string',
                'password'           => 'required|string',
                recaptchaFieldName() => recaptchaRuleName(),
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Rules\GoogleRecaptcha;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {

        sendLoginResponse as protected traitsendLoginResponse;
        sendFailedLoginResponse as protected traitsendFailedLoginResponse;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user)
    {
        if (Auth::user()->hasRole('Admin|staff')) {
            return redirect('/home');
        }
              return redirect('/');
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

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => new GoogleRecaptcha() ,
        ]);
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }

 

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->forget('loginAttempts');
        return $this->traitsendLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {

        session()->put('loginAttempts', $this->limiter()->attempts($this->throttleKey($request)));
        $this->traitsendFailedLoginResponse($request);
    }
}

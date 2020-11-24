<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Ldap\User;
use App\Providers\RouteServiceProvider;
use DebugBar\DebugBar;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;

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

    use AuthenticatesUsers, ListensForLdapBindFailure;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->listenForLdapBindFailure();
    }

    protected function credentials(Request $request)
    {
        (preg_match('/^(\S+)(?=@)/', $request->email, $matches, PREG_OFFSET_CAPTURE, 0));

        return [

            'uid' => $matches[0],
            'mail' => $request->email,
            'password' => $request->password,
            'fallback' => [
                'email' => $request->email,
                'password' => $request->password,
            ],
        ];
    }

    public function authenticate(Request $request)
    {
        #$credentials = $request->only('email', 'password');
        $credentials = $request->only('uid', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/');
        }
    }


}

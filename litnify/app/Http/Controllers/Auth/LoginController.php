<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'mail' : 'uid';

        return [
            $fieldType => $request->login,
            'password' => $request->password,
            'fallback' => [
                'email' => $request->login,
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

    protected function validateLogin(Request $request)
    {
        // check if User is NOT disabled by admin panel -> admin/nutzerverwaltung
        /*
        $this->validate($request, [
            $this->username() => 'exists:users,' . $this->username() . ',deleted,0',
            'password' => 'required|string',
            ]);
        */
        $this->validate($request, [
            $this->username() => Rule::exists('users')->where(function ($query) {
                $query->where('deleted', 0);
            }),
            'password' => 'required|string'
        ],
            [
                $this->username() . '.exists' => 'Ihr Account ist ungültig oder wurde deaktiviert.'
            ]);
    }
}

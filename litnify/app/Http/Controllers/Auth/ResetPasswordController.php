<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /*
    protected function credentials(\Illuminate\Http\Request $request)
    {
        $db_user = (User::where('email',$request->email)->first()->guid == null) ? true : false;
        if(true){
            $response = 'Passwörter für LDAP Accounts können nicht über diese Funktion zurückgesetzt werden.';

            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => $response]);
        }
        return $request->only('email');
    }
    */


    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}

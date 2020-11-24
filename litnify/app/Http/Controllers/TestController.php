<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use LdapRecord\Ldap;

class TestController
{

    public function index(){


            $email = 'test@test.de';
            $password = 'password';


        dd(Auth::attempt(array('email' => $email, 'password' => bcrypt($password))));

    }

}

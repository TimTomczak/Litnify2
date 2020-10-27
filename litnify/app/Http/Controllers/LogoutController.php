<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LogoutController extends Controller
{
    public function index(){

        Auth::logout();
        return redirect('/');

    }


}

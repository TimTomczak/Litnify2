<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LogoutController extends Controller
{
    public function index()
    {
        Auth::logout();
        return redirect(RouteServiceProvider::HOME);
    }
}

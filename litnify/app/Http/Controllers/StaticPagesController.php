<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{

    public function __invoke()
    {
        return view('pages.' . request()->segment(1));
    }







}

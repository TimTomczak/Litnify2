<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeitenController extends Controller
{

    public function __invoke()
    {
        return view('pages.' . request()->segment(1));
    }







}

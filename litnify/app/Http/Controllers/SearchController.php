<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){

        //dd($request);
        $result = "leer";
        return view('search/index', array('request' => $request, 'result'  => $result) );

    }
}

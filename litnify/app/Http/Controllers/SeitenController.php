<?php

namespace App\Http\Controllers;

use App\Models\Seiten;
use Illuminate\Http\Request;

class SeitenController extends Controller
{

    public function __invoke()
    {
        $url = request()->segment(1);
        $content = Seiten::getByTitle($url);

        return view('layouts.staticpages', array('content' => $content));
    }







}

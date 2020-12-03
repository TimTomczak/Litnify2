<?php

namespace App\Http\Controllers;

use App\Models\Seiten;
use Illuminate\Http\Request;

class SeitenController extends Controller
{

    public function __invoke()
    {
        $url = request()->segment(1);
        $content = Seiten::where('title', $url)->latest('created_at')->value('content');
        return view('layouts.staticpages', [
            'content' => $content,
            'title' => $url
        ]);
    }
}

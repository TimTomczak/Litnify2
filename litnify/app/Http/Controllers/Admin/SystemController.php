<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    public function index(){
        Log::info('Logging funktioniert');
    }


    public function logs(Request $request){

        $date = new Carbon($request->get('date', today()));

        $filePath = storage_path("logs/laravel-{$date->format('Y-m-d')}.log");
        $data = [];

        if(File::exists($filePath)){
            $data = [
                'lastModified' => new Carbon(File::lastModified($filePath)),
                'size' => File::size($filePath),
                'file' => File::get($filePath),
            ];

        }

        return view('admin.systemverwaltung.logs', compact('date', 'data'));

    }
}

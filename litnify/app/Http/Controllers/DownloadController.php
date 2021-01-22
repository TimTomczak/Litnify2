<?php

namespace App\Http\Controllers;

use App\Exports\AusleihenExport;
use App\Exports\MediumExport;
use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MerklisteExport;


class DownloadController extends Controller{

    public function index(Request $request){

        $download = new Download();
        $download->list = $request->export;
        $download->extension = $request->type;
        return $download->download();

    }
}

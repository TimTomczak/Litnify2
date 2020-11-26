<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class Download extends Controller{


    private $data;

    public function index(Request $request){

            $this->xlsExport($request);

    }

    public function pdfExport(){



    }
    public function xlsExport($request){



       return $this->data->download($request->server, 'export.xls');

    }
    public function csvExport(){


    }
    public function texExport(){


    }









}

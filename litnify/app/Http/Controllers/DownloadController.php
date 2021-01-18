<?php

namespace App\Http\Controllers;

use App\Exports\AusleihenExport;
use App\Exports\MediumExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MerklisteExport;


class DownloadController extends Controller{

    public function index(Request $request){

        $export = $request->export;
        $file = $request->type;

        switch($export)
        {
            case ("merkliste"):
                $exportObject = new MerklisteExport();

                return Excel::download(new MerklisteExport, 'merkliste.xlsx');

                break;
            case ("ausleihen"):
                $exportObject = new AusleihenExport();
                break;
        }



        /*
         * Ausleihen
         * Merkliste
         * Nutzer
         *
         * */





        //Redirect::back();
        //return Excel::download(new MerklisteExport, 'merkliste.xlsx');

    }

    public function pdfExport(){



    }
    public function xlsExport($request){


        //return (new InvoicesExport)->download('export.xlsx', Excel::XLSX);


    }
    public function csvExport(){


        //return (new MediumExport)->download('export.csv', Excel::CSV, [
        //    'Content-Type' => 'text/csv',
        //]);

    }
    public function texExport(){



    }









}

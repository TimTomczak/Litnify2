<?php

namespace App\Http\Controllers;

use App\Exports\MediumExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;


class DownloadController extends Controller{

    private $data;

    public function index(Request $request){

        //dd($request);

        //$this->xlsExport($request);

        return Excel::download(new MediumExport, 'medien.xlsx');
    }

    public function pdfExport(){



    }
    public function xlsExport($request){


        return (new InvoicesExport)->download('export.xlsx', Excel::XLSX);


    }
    public function csvExport(){


        return (new MediumExport)->download('export.csv', Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);

    }
    public function texExport(){



    }









}

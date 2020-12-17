<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use App\Models\Medium;
use App\Models\Zeitschrift;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WiederherstellungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {



    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($verwaltung)
    {
        $verwaltung=ucfirst($verwaltung);
        $optionen=[
            'Medien',
            'Ausleihen',
            'Zeitschriften',
        ];
        if(in_array($verwaltung,$optionen)===false){
            abort('403','Keine gültige Wiederherstellungsoption');
        }

        switch ($verwaltung){
            case 'Medien':
                $deletedItems = Medium::whereDeleted(1);
                $tableBuilder = TableBuilder::$medienverwaltungIndex;
                break;

            case 'Ausleihen':
                $deletedItems = Ausleihe::whereDeleted(1);
                $tableBuilder = TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen;
                break;

            case 'Zeitschriften':
                $deletedItems = Zeitschrift::whereDeleted(1);
                $tableBuilder = TableBuilder::$zeitschrifenverwaltungIndex;
                break;
        }

        return view('admin.wiederherstellung.wiederherstellung'.$verwaltung,[
            'deletedItems' => $deletedItems,
            'verwaltung'=>$verwaltung,
            'tableBuilder' => $tableBuilder,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recover($type, $id)
    {
        $types=['medium','zeitschrift']; //TODO  ,'ausleihe'

        if (in_array($type,$types)===false){
            abort('403','Typ "'.$type.'" kann nicht wiederhergestellt werden !');
        }

        dd($type,$id);
    }

}

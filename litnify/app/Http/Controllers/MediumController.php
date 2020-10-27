<?php

namespace App\Http\Controllers;

use App\Models\Literaturart;
use App\Models\Medium;
use App\Util\Display;
use App\Util\Names;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MediumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $medien = Medium::orderBy('id','DESC')->limit(10)->get(); //Die letzten 100 Medien
        $mappedMedien=$this->mapForeignKeyReferences($medien);

        return view('Medienverwaltung.index',[
            'medien' => $mappedMedien
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
//        $validatedAttributes=$this->validateAttributes();
//        Medium::create($validatedAttributes);
//        return redirect('/Medium/'.$validatedAttributes['id']);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Medium $medium)
    {
        $medColl= collect(new Medium());
        $medColl->add($medium);
        $mappedMedien=$this->mapForeignKeyReferences($medColl);

        return view('Medienverwaltung.show',[
            'medium' => $medium
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medium  $medium
     * @return \Illuminate\Http\Response
     */
    public function edit(Medium $medium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medium  $medium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medium $medium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medium  $medium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medium $medium)
    {
        //
    }

    private function validateAttributes(){
        $validatedAttributes = request()->validate([
            'id' => 'required',
//            'literaturart_id' => '',
            'signatur' => '',
            'autoren' => '',
            'hauptsachtitel' => 'required',
//            'untertitel' => '',
//            'enthalten_in' => '',
//            'erscheinungsort' => '',
            'jahr' => 'required',
//            'verlag' => '',
//            'isbn' => '',
//            'issn' => '',
//            'doi' => '',
//            'inventarnummer' => '',
//            'auflage' => '',
//            'herausgeber' => '',
//            'schriftenreihe' => '',
//            'zeitschrift_id' => '',
//            'band' => '',
//            'seite' => '',
//            'institut' => '',
//            'raum_id' => '',
//            'bemerkungen' => '',
        ]);
        return $validatedAttributes;
    }
}

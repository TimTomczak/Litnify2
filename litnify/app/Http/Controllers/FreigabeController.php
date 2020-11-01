<?php

namespace App\Http\Controllers;

use App\Models\Medium;
use Illuminate\Http\Request;

class FreigabeController extends MediumController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $medien = Medium::orderBy('id','DESC')
            ->where('released',0)
            ->where('deleted',0)
            ->limit(100)->get(); //Die letzten 100 Medien
        $mappedMedien=$this->mapForeignKeyReferences2String($medien);
        return view('Freigabe.index',[
            'medien' => $mappedMedien
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medium  $medium
     */
    public function update(Request $request, Medium $medium)
    {
        $medium->update(['released'=>1]);
        return redirect(route('freigabe.index'));
    }

}

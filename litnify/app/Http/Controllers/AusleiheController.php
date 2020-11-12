<?php

namespace App\Http\Controllers;

use App\Models\Ausleihe;
use App\Models\Merkliste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AusleiheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
//        $ausleihen = Ausleihe::with([
//            'user'=> function($usr){
//                $usr->groupBy('id');
//            },
//            'medium'
//        ]);
        $merk = Merkliste::with('user', 'medium')->groupBy('user_id')->get();
        return view('Ausleihverwaltung.index',[
            'merklisten' => $merk,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Ausleihe  $ausleihe
     * @return \Illuminate\Http\Response
     */
    public function show(Ausleihe $ausleihe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     * @return \Illuminate\Http\Response
     */
    public function edit(Ausleihe $ausleihe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ausleihe  $ausleihe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ausleihe $ausleihe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ausleihe $ausleihe)
    {
        //
    }
}

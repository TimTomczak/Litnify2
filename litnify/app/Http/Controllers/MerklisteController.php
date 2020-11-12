<?php

namespace App\Http\Controllers;

use App\Models\Merkliste;
use App\Models\User;
use Illuminate\Http\Request;

class MerklisteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Merkliste  $merkliste
     * @return \Illuminate\Http\Response
     */
    public function show(Merkliste $merkliste)
    {
        //
    }

    /**
     * Display the specified resource.
     * show-Methode für den Admin-Bereich
     *
     * @param  \App\Models\Merkliste  $merkliste
     */
    public function showMerkliste(User $user)
    {
        return view('Ausleihverwaltung.showMerkliste',[
            'merkliste' => $user->medium,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merkliste  $merkliste
     * @return \Illuminate\Http\Response
     */
    public function edit(Merkliste $merkliste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merkliste  $merkliste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merkliste $merkliste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merkliste  $merkliste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merkliste $merkliste)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Merkliste;
use App\Models\User;
use Illuminate\Http\Request;

class MerklistenverleihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $merk = Merkliste::with('user', 'medium')->groupBy('user_id')->get();
        return view('Merklistenverleih.index',[
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
     *  Zeigt die Merklsite des jeweils ausgewählten Benutzers in der Ausleihverwaltung
     */
    public function show(User $user)
    {
        $medienAufMerkliste = $user->merkliste;
        return view('Merklistenverleih.show',[
            'merkliste' => $medienAufMerkliste,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

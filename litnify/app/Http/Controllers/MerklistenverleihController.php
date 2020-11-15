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
     *  Zeigt die Merklsite des jeweils ausgewählten Benutzers in der Ausleihverwaltung
     */
    public function show(User $user)
    {
        $medienAufMerkliste = $user->merkliste;
        return view('Merklistenverleih.show',[
            'merkliste' => $medienAufMerkliste,
            'user' => $user,
            'ausleihdauerDefault' => 28 /*TODO Ausleihdauer aus parameter übergeben*/
        ]);
    }


}

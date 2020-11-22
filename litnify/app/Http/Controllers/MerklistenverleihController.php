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
        $merk = Merkliste::with('user', 'medium')->groupBy('user_id')->paginate(10);
        return view('Ausleihverwaltung/Merklistenverleih.index',[
            'merklisten' => $merk,
        ]);
    }

    /**
     *  Zeigt die Merklsite des jeweils ausgewählten Benutzers in der Ausleihverwaltung
     */
    public function show(User $user)
    {
        $medienAufMerkliste = $user->merkliste->paginate(10);
        return view('Ausleihverwaltung/Merklistenverleih.show',[
            'merkliste' => $medienAufMerkliste,
            'user' => $user,
            'ausleihdauerDefault' => 28 /*TODO Ausleihdauer aus parameter übergeben*/
        ]);
    }


}

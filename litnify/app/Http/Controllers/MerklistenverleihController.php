<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
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
        return view('admin.ausleihverwaltung.merklistenverleih.index',[
            'merklisten' => $merk,
            'tableStyle' => TableBuilder::$tableStyle,
        ]);
    }

    /**
     *  Zeigt die Merklsite des jeweils ausgewählten Benutzers in der Ausleihverwaltung
     */
    public function show(User $user)
    {
        $medienAufMerkliste = $user->merkliste->paginate(10);
        return view('admin.ausleihverwaltung.merklistenverleih.show',[
            'merkliste' => $medienAufMerkliste,
            'user' => $user,
            'tableStyle' => TableBuilder::$tableStyle,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Medium;
use App\Models\Merkliste;
use App\Models\User;
use Illuminate\Http\Request;

class MerklistenverleihController extends Controller
{
    /**
     * Ansicht aller Nutzer, die Medien auf ihrere Merklsite haben, deren Anzahl, sowie die Anzahl
     * der davon ausleihbaren Medien
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
        $medienAufMerkliste = $user->merkliste;
        $medienAufMerklisteAusleihbar=$medienAufMerkliste->filter(function (Medium $medium){
            if ($medium->isAusleihbar()){
                return $medium;
            }
        });

        return view('admin.ausleihverwaltung.merklistenverleih.show',[
            'merkliste' => $medienAufMerkliste->paginate(10),
            'merklisteAusleihbar' => $medienAufMerklisteAusleihbar->paginate(10),
            'user' => $user,
            'tableStyle' => TableBuilder::$tableStyle,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }


}

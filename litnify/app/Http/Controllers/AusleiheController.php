<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use App\Models\Medium;
use App\Models\Merkliste;
use App\Models\User;
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
//        $ausleihenAktiv = Ausleihe::with('medium','user')->where('RueckgabeIst',null)->paginate(10);
//        $ausleihenAktiv = $this->dbTimestampToGermanDate($ausleihenAktiv);
        return view('Ausleihverwaltung.index',[
//            'ausleihenAktiv' => $ausleihenAktiv,
            'showAktiv'=>true,
            'tableBuilderAktiv' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableBuilderBeendet' => TableBuilder::$ausleihverwaltungIndex_BeendeteAusleihen,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }

    public function indexAusleihenBeendet()
    {
//        $ausleihenBeendet = Ausleihe::with('medium','user')->whereNotNull('RueckgabeIst')->paginate(10);
//        $ausleihenBeendet = $this->dbTimestampToGermanDate($ausleihenBeendet);
        return view('Ausleihverwaltung.indexAusleihenBeendet',[
//            'ausleihenBeendet' => $ausleihenBeendet,
            'showAktiv'=>false,
            'tableBuilderAktiv' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableBuilderBeendet' => TableBuilder::$ausleihverwaltungIndex_BeendeteAusleihen,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
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
     */
    public function store(Request $request, User $user,  Medium $medium)
    {
        $ausleihzeitraum = $request->get('ausleihzeitraum');
        $ausleihzeitraumSplit = explode(' - ',$ausleihzeitraum);

        $request->request->add([
            'medium_id' => $medium->id,
            'user_id' => $user->id,
            'Ausleihdatum' => date("Y-m-d",strtotime($ausleihzeitraumSplit[0])),
            'RueckgabeSoll' => date("Y-m-d",strtotime($ausleihzeitraumSplit[1]))
        ]);
        Ausleihe::create($this->validateAttributes($request));
        return redirect(route('ausleihe.show',$user))->with([
            'title' => 'Ausleihverwaltung',
            'message'=>'Verleih des Mediums "'.$medium->id.'" mit der Inventarnummer ['.$request->request->get('inventarnummer').'] erfolgreich.',
            'alertType' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     */
    public function show($user)
    {
        $user=User::find($user);
        $ausleihenAktiv = Ausleihe::whereUserId($user->id)->whereNull('RueckgabeIst')->get();
        $ausleihenAktiv = $this->dbTimestampToGermanDate($ausleihenAktiv);
        $ausleihenBeendet = Ausleihe::whereUserId($user->id)->whereNotNull('RueckgabeIst')->get();
        $ausleihenBeendet = $this->dbTimestampToGermanDate($ausleihenBeendet);

        return view('Ausleihverwaltung.show',[
            'ausleihenAktiv' => $ausleihenAktiv->paginate(10),
            'ausleihenBeendet' => $ausleihenBeendet->paginate(10),
            'user' => $user,
            'tableStyle' => TableBuilder::$tableStyle,
            'tableBuilderAktiv' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableBuilderBeendet' => TableBuilder::$ausleihverwaltungIndex_BeendeteAusleihen,
            'tableBuilder' => TableBuilder::$zeitschrifenverwaltungIndex,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     * @return \Illuminate\Http\Response
     */
    public function edit(Ausleihe $ausleihe)
    {
        return abort('403','Bearbeiten von Ausleihen ist derzeit nicht implementiert');
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
        return abort('403','Ändern von Ausleihen ist derzeit nicht implementiert');
    }

    /**
     * Recover the specified resource in storage.
     *
     * @param  Ausleihe $ausleihe
     */
    public function recover(Ausleihe $ausleihe)
    {
        $ausleihe->update(['deleted'=>0]);
        return back()->with([
            'title' => 'Wiederherstellung',
            'message' => 'Ausleihe "'.$ausleihe->id.'" wurde wiederhergestellt.',
            'alertType'=> 'success'
        ]);
    }

    public function updateVerlaegerungen(Request $request, Ausleihe $ausleihe)
    {
        $request->validate([
            'id' => 'required|integer',
            'verlaengerung' => 'date|required'
        ]);

        if ($ausleihe->RueckgabeIst!=null){
            abort('403','Medium wurde bereits zurückgegeben');
        }


        $ausleihe->update([
            'id' => $request->id,
            'RueckgabeSoll' => date('Y-m-d',strtotime($request->verlaengerung)),
            'Verlaengerungen' => $ausleihe->Verlaengerungen+1
        ]);

        return back()->with([
            'title' => 'Ausleihverwaltung',
            'message'=>'Ausleihe erfolgreich verlängert',
            'alertType' => 'success'
        ]);
    }

    public function updateRueckgabe(Request $request, Ausleihe $ausleihe)
    {
        $request->validate([
            'id' => 'required|integer',
            'rueckgabe' => 'date|required'
        ]);

        if ($ausleihe->RueckgabeIst!=null){
            abort('403','Medium wurde bereits zurückgegeben');
        }

        $ausleihe->update([
            'id' => $request->id,
            'RueckgabeIst' => date('Y-m-d',strtotime($request->rueckgabe)),
        ]);

        return back()->with([
            'title' => 'Ausleihverwaltung',
            'message'=>'Rückgabe erfolgreich verbucht.',
            'alertType' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ausleihe $ausleihe)
    {
        return abort('403','Löschen von Ausleihen ist derzeit nicht implementiert');
    }

    private function dbTimestampToGermanDate($ausleihen)
    {
        foreach ($ausleihen as $ausleihe) {
            $ausleihe->RueckgabeSoll = $ausleihe->RueckgabeSoll != null ? date("d.m.Y", strtotime($ausleihe->RueckgabeSoll)) : $ausleihe->RueckgabeSoll;
            $ausleihe->Ausleihdatum = $ausleihe->Ausleihdatum != null  ? date("d.m.Y", strtotime($ausleihe->Ausleihdatum)) : $ausleihe->Ausleihdatum;
            $ausleihe->RueckgabeIst = $ausleihe->RueckgabeIst != null ? date("d.m.Y", strtotime($ausleihe->RueckgabeIst)) : $ausleihe->RueckgabeIst;
        }
        return $ausleihen;
    }

    private function validateAttributes(Request $request){
//        dd(request());
        return request()->validate([
            'medium_id' => 'required|integer',
            'user_id' => 'required|integer',
            'inventarnummer' => 'required|string',
            'Ausleihdatum' => 'required|date',
            'RueckgabeSoll' => 'required|date'
        ]);
    }
}

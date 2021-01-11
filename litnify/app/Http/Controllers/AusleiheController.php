<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use App\Models\Medium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class AusleiheController
 * @package App\Http\Controllers
 */
class AusleiheController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.ausleihverwaltung.index',[
            'showAktiv'=>true,                                                                  //wird in der view an Livewire-Component übergeben. Diese lädt entsprechend true oder false die aktiven oder beendeten Ausleihen
            'tableBuilderAktiv' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableBuilderBeendet' => TableBuilder::$ausleihverwaltungIndex_BeendeteAusleihen,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexAusleihenBeendet()
    {
        return view('admin.ausleihverwaltung.indexAusleihenBeendet',[
            'showAktiv'=>false,                                                                 // s.o.
            'tableBuilderAktiv' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableBuilderBeendet' => TableBuilder::$ausleihverwaltungIndex_BeendeteAusleihen,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Bekommt den Ausleihzeitraum, User und das auszuleihende Medium.
     * Teilt den Ausleihzeitraum (z.B: "01.01.2020 - 29.01.2020") auf und speichert daraus das jeweilige Ausleihdatum
     * und RueckgabeSoll
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
            'RueckgabeSoll' => date("Y-m-d",strtotime($ausleihzeitraumSplit[1])),
            'deleted' => 0,
        ]);

        Ausleihe::create($this->validateAttributes($request));
        return back()->with([
            'title' => 'Ausleihverwaltung',
            'message'=>'Verleih des Mediums "'.$medium->id.'" mit der Inventarnummer ['.$request->request->get('inventarnummer').'] erfolgreich.',
            'alertType' => 'success'
        ]);
    }

    /**
     * Zeigt alle aktiven und beendeten Ausleihen eines Benutzers an
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     */
    public function show($user)
    {
        $user=User::find($user);
        $ausleihenAktiv = Ausleihe::whereUserId($user->id)->whereNull('RueckgabeIst')->get();
        $ausleihenAktiv = $this->dbTimestampToGermanDate($ausleihenAktiv);                                  //Datenbank-Timestamp in deutsches Datum für die Anzteige umwandeln
        $ausleihenBeendet = Ausleihe::whereUserId($user->id)->whereNotNull('RueckgabeIst')->get();
        $ausleihenBeendet = $this->dbTimestampToGermanDate($ausleihenBeendet);

        return view('admin.ausleihverwaltung.show',[
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
     */
    public function edit(Ausleihe $ausleihe)
    {
        $ausleihe=$this->dbTimestampToGermanDate([$ausleihe])[0];
        return view('admin.ausleihverwaltung.edit',[
            'ausleihe'=>$ausleihe,
            'user'=>User::findOrFail($ausleihe->user_id),
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ausleihe  $ausleihe
     */
    public function update(Request $request, Ausleihe $ausleihe)
    {
        $request->validate([
            'id' => ['required','numeric',Rule::in([$ausleihe->id])],
            'inventarnummer' => 'required|string',
            'ausleihzeitraumEdit' => 'required'
        ]);

        $ausleihzeitraum = $request->get('ausleihzeitraumEdit');
        $ausleihzeitraumSplit = explode(' - ',$ausleihzeitraum);

        $ausleihe->update([
            'id' => $request->id,
            'inventarnummer' => $request->inventarnummer,
            'Ausleihdatum' => date("Y-m-d",strtotime($ausleihzeitraumSplit[0])),
            'RueckgabeSoll' => date("Y-m-d",strtotime($ausleihzeitraumSplit[1]))
        ]);
        return back()->with([
            'title' => 'Ausleihverwaltung',
            'message'=>'Ausleihe wurde geändert.',
            'alertType' => 'success'
        ]);
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

    /**
     * @param Request $request
     * @param Ausleihe $ausleihe
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param Request $request
     * @param Ausleihe $ausleihe
     * @return \Illuminate\Http\RedirectResponse
     */
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
     */
    public function destroy(Ausleihe $ausleihe)
    {
        $ausleihe->update(['deleted'=>1]);
        return back()->with([
            'title' => 'Ausleihverwaltung',
            'message'=>'Ausleihe gelöscht.',
            'alertType' => 'danger'
        ]);
    }

    /**
     * @param $ausleihen
     * @return mixed
     */
    private function dbTimestampToGermanDate($ausleihen)
    {
        foreach ($ausleihen as $ausleihe) {
            $ausleihe->RueckgabeSoll = $ausleihe->RueckgabeSoll != null ? date("d.m.Y", strtotime($ausleihe->RueckgabeSoll)) : $ausleihe->RueckgabeSoll;
            $ausleihe->Ausleihdatum = $ausleihe->Ausleihdatum != null  ? date("d.m.Y", strtotime($ausleihe->Ausleihdatum)) : $ausleihe->Ausleihdatum;
            $ausleihe->RueckgabeIst = $ausleihe->RueckgabeIst != null ? date("d.m.Y", strtotime($ausleihe->RueckgabeIst)) : $ausleihe->RueckgabeIst;
        }
        return $ausleihen;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateAttributes(Request $request){
        return request()->validate([
            'medium_id' => 'required|integer',
            'user_id' => 'required|integer',
            'inventarnummer' => 'required|string',
            'Ausleihdatum' => 'required|date',
            'RueckgabeSoll' => 'required|date',
            'deleted' => 'required|integer',
        ]);
    }
}

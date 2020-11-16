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
    private function dbTimestampToGermanDate($ausleihen)
    {
        foreach ($ausleihen as $ausleihe) {
            $ausleihe->RueckgabeSoll = $ausleihe->RueckgabeSoll != null&& $ausleihe->RueckgabeSoll!='0000-00-00' ? date("d.m.Y", strtotime($ausleihe->RueckgabeSoll)) : $ausleihe->RueckgabeSoll;
            $ausleihe->Ausleihdatum = $ausleihe->Ausleihdatum != null && $ausleihe->Ausleihdatum!='0000-00-00' ? date("d.m.Y", strtotime($ausleihe->Ausleihdatum)) : $ausleihe->Ausleihdatum;
            $ausleihe->RueckgabeIst = $ausleihe->RueckgabeIst != null && $ausleihe->RueckgabeIst!='0000-00-00' ? date("d.m.Y", strtotime($ausleihe->RueckgabeIst)) : $ausleihe->RueckgabeIst;
        }
        return $ausleihen;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $ausleihenAktiv = Ausleihe::with('medium','user')->where('RueckgabeIst',null)->get();
        $ausleihenAktiv = $this->dbTimestampToGermanDate($ausleihenAktiv);
        $ausleihenBeendet = Ausleihe::with('medium','user')->whereNotNull('RueckgabeIst')->get();
        $ausleihenBeendet = $this->dbTimestampToGermanDate($ausleihenBeendet);
        return view('Ausleihverwaltung.index',[
            'ausleihenAktiv' => $ausleihenAktiv,
            'ausleihenBeendet' => $ausleihenBeendet,
            'tableBuilderAktiv' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableBuilderBeendet' => TableBuilder::$ausleihverwaltungIndex_BeendeteAusleihen,
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
            'message'=>'Verleih des Mediums "'.$medium->hauptsachtitel.'" mit der Inventarnummer ['.$request->request->get('inventarnummer').'] erfolgreich.',
            'alertType' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ausleihe  $ausleihe
     */
    public function show(User $user)
    {
        $ausleihenAktiv = Ausleihe::whereUserId($user->id)->whereNull('RueckgabeIst')->get();
        $ausleihenAktiv = $this->dbTimestampToGermanDate($ausleihenAktiv);
        $ausleihenBeendet = Ausleihe::whereUserId($user->id)->whereNotNull('RueckgabeIst')->get();
        $ausleihenBeendet = $this->dbTimestampToGermanDate($ausleihenBeendet);

        return view('Ausleihverwaltung.show',[
            'ausleihenAktiv' => $ausleihenAktiv,
            'ausleihenBeendet' => $ausleihenBeendet,
            'user' => $user,
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

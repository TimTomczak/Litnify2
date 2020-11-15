<?php

namespace App\Http\Controllers;

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
        $ausleihenAktiv = Ausleihe::with('medium','user')->where('RueckgabeIst',null)->get();
        $ausleihenBeendet = Ausleihe::with('medium','user')->whereNotNull('RueckgabeIst')->get();
        return view('Ausleihverwaltung.index',[
            'ausleihenAktiv' => $ausleihenAktiv,
            'ausleihenBeendet' => $ausleihenBeendet
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
        return redirect(route('merklistenverleih.show',$user))->with(['message'=>'Verleih des Mediums "'.$medium->hauptsachtitel.'" mit der Inventarnummer ['.$request->request->get('inventarnummer').'] erfolgreich.']);
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

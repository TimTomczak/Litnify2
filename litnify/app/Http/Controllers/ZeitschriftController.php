<?php

namespace App\Http\Controllers;

use App\Models\Zeitschrift;
use Illuminate\Http\Request;

class ZeitschriftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('Zeitschriftenverwaltung.index',[
            'zeitschriften' => Zeitschrift::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('zeitschriftenverwaltung.create',[
            'nextId' => $this->getNextAutoincrement('zeitschriften')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
        $zeitschrift = Zeitschrift::create($this->validateAttributes());
        $zeitschrift->save();
        return redirect(route('zeitschriftenverwaltung.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zeitschrift  $zeitschrift
     */
    public function edit(Zeitschrift $zeitschrift)
    {
        return view('Zeitschriftenverwaltung.edit',[
            'zeitschrift' => $zeitschrift
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zeitschrift  $zeitschrift
     */
    public function update(Request $request, Zeitschrift $zeitschrift)
    {
        $zeitschrift->update($this->validateAttributes());
        return redirect(route('zeitschrift.edit',$zeitschrift->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zeitschrift  $zeitschrift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zeitschrift $zeitschrift)
    {
        // TODO Zeitschriften löschen
        echo 'Löschen noch nicht implementiert. Dauerhaft löschen, oder nur "inaktivieren" ?';
    }

    public function validateAttributes(){
        $validatedAttributes = request()->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'shortcut' => 'required|string'
        ]);
        return $validatedAttributes;
    }
}

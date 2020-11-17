<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
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
            'zeitschriften' => Zeitschrift::where('deleted',0)->paginate(10),
            'tableBuilder' => TableBuilder::$zeitschrifenverwaltungIndex,
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
        if ($zeitschrift->deleted==1){
            abort('403','Zeitschrift wurde gelöscht');
        }
        else{
            return view('Zeitschriftenverwaltung.edit',[
                'zeitschrift' => $zeitschrift
            ]);
        }

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
     */
    public function destroy(Zeitschrift $zeitschrift)
    {
        $zeitschrift->update(['deleted'=>1]);
        return redirect(route('zeitschriften.index',$zeitschrift->id))->with([
            'message' => 'Zeitschrift wurde gelöscht.',
            'alertType'=> 'info'
        ]);
    }

    public function validateAttributes(){
        $validatedAttributes = request()->validate([
//            'id' => 'required|integer',
            'name' => 'required|string',
            'shortcut' => 'required|string'
        ]);
        return $validatedAttributes;
    }
}

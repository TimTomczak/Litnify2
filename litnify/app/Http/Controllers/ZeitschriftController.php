<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Zeitschrift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ZeitschriftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.zeitschriftenverwaltung.index',[
            'zeitschriften' => Zeitschrift::where('deleted',0)->paginate(10),
            'tableStyle' => TableBuilder::$tableStyle,
            'tableBuilder' => TableBuilder::$zeitschrifenverwaltungIndex,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.zeitschriftenverwaltung.create',[
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
        $zeitschrift=Zeitschrift::create($this->validateAttributes());
        return redirect(route('zeitschriften.index'))->with([
            'title' => 'Zeitschriftenverwaltung',
            'message' => 'Zeitschrift erfolgreich erstellt.',
            'alertType'=> 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zeitschrift  $zeitschrift
     */
    public function edit(Zeitschrift $zeitschrift)
    {

        if ($zeitschrift->deleted==1){
            if (Auth::check()) {
                if (Auth::user()->berechtigungsrolle_id < 3) {
                    return abort('403', 'Zeitschrift wurde gelöscht');
                }
                else{
                    return view('Zeitschriftenverwaltung.edit',[
                        'zeitschrift' => $zeitschrift
                    ]);
                }
            }
            else{
                return abort('403', 'Zeitschrift wurde gelöscht');
            }
        }
        else{
            return view('admin.zeitschriftenverwaltung.edit',[
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
        return back()->with([
            'title' => 'Zeitschriftenverwaltung',
            'message' => 'Zeitschrift wurde geändert.',
            'alertType'=> 'success'
        ]);
    }

    /**
     * Recover the specified resource in storage.
     *
     * @param  Zeitschrift $zeitschrift
     */
    public function recover(Zeitschrift $zeitschrift)
    {
        $zeitschrift->update(['deleted'=>0]);
        return back()->with([
            'title' => 'Wiederherstellung',
            'message' => 'Zeitschrift "'.$zeitschrift->id.'" wurde wiederhergestellt.',
            'alertType'=> 'success'
        ]);
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
            'title' => 'Zeitschriftenverwaltung',
            'message' => 'Zeitschrift wurde gelöscht.',
            'alertType'=> 'danger'
        ]);
    }

    public function validateAttributes(){
        return $validatedAttributes = request()->validate([
            'name' => 'required|string',
            'shortcut' => 'required|string'
        ]);
    }
}

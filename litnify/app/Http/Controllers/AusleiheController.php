<?php

namespace App\Http\Controllers;

use App\Models\Ausleihe;
use Illuminate\Http\Request;

class AusleiheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null, $action = null)
    {
        switch ($action) {
            case 'edit':
                return $this->edit(Ausleihe::getById($id));
            break;
            case 'update':
                return $this->update($id);
            break;
            case 'delete':
                return $this->destroy($id);
            break;
            default:
                return $this->show($id);
            }
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}

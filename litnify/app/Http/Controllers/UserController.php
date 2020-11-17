<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use App\Models\Berechtigungsrolle;
use App\Models\Merkliste;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\Models\User::all();
        return view('admin.nutzerverwaltung.index', [
            'users' => $users,
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showProfil(){
        return view('user/profil', array('user' => Auth::user()));
    }

    public function showMerkliste(){
        return view('user/merkliste', array('user' => Auth::user(), 'merkliste' => (Auth::user())->merkliste));
    }

    public function showAusleihen(){
        return view('user/ausleihen', array('user' => Auth::user(), 'ausleihe' => Auth::user()->ausleihe));
    }
}

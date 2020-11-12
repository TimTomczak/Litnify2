<?php

namespace App\Http\Controllers;

use App\Models\Berechtigungsrolle;
use App\Models\Merkliste;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $user = Auth::user();
        $rolle = (Berechtigungsrolle::all()->where('id', '=', $user->berechtigungsrolle_id));
        return view('user/profil', array('user' => $user, 'rolle' => $rolle));
    }

    public function showMerkliste(){
        $user = Auth::user();


        $merkliste = Merkliste::all()->where('user_id', '=', $user->id);
        return view('user/merkliste', array('user' => $user, 'merkliste' => $merkliste));
    }

    public function showAusleihen(){
        $user = Auth::user();
        $merkliste = Merkliste::all()->where('user_id', '=', $user->id);
        return view('user/ausleihen', array('user' => $user, 'merkliste' => $merkliste));
    }





}

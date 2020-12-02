<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TableBuilder;
use App\Http\Controllers\Controller;
use App\Models\Berechtigungsrolle;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $users = \App\Models\User::all();
        return view('admin.nutzerverwaltung.index', [
            'users' => $users,
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);

    }

    public function edit(User $user)
    {
        return view('admin.nutzerverwaltung.edit', ['user' => $user, 'rollen' => Berechtigungsrolle::all()]);
    }

    public function update(Request $request, User $user)
    {
        //dd($request);


        $user->update($request->validate([
            'nachname' => 'string',
            'vorname' => 'string',

        ]));

        return redirect(route('admin.nutzerverwaltung'))->with([
            'message' => 'Account wurde geändert.',
            'alertType'=> 'info'
        ]);
    }


    public function destroy(User $user)
    {

        dd($user);

        $user->update(['deleted'=>1]);
        return redirect(route('admin.nutzerverwaltung'))->with([
            'message' => 'User wurde gelöscht.',
            'alertType'=> 'info'
        ]);
    }

}

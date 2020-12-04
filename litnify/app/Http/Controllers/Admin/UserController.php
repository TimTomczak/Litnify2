<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TableBuilder;
use App\Http\Controllers\Controller;
use App\Models\Berechtigungsrolle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function index()
    {

        $users = User::all(); //@todo Pagination
        return view('admin.nutzerverwaltung.index', [
            'users' => $users,
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }

    public function create()
    {
        return view('admin.nutzerverwaltung.create', ['rollen' => Berechtigungsrolle::all()]);
    }

    public function createUser(Request $request)
    {
        User::create([
            'nachname' => $request->nachname,
            'vorname' => $request->vorname,
            'email' => $request->email,
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return redirect(route('admin.nutzerverwaltung'))->with([
            'title' => 'Nutzerverwaltung',
            'message' => __($status),
            'alertType'=> 'info'
        ]);

        /*
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
        */

    }

    public function edit(User $user)
    {
        if($user->id == Auth::user()->id){
            return redirect(route('admin.nutzerverwaltung'))->with([
                'title' => 'Nutzerverwaltung',
                'message' => 'Angemeldeter Account kann nicht verändert werden.',
                'alertType'=> 'danger'
            ]);
        }
        else{
            return view('admin.nutzerverwaltung.edit', ['user' => $user, 'rollen' => Berechtigungsrolle::all()]);
        }

    }

    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            'nachname' => 'string',
            'vorname' => 'string',
            'berechtigungsrolle_id' => 'required|string'
        ]));
        return redirect(route('admin.nutzerverwaltung'))->with([
            'title' => 'Nutzerverwaltung',
            'message' => 'Account wurde geändert.',
            'alertType'=> 'info'
        ]);
    }

    public function destroy(User $user)
    {
        $user->update(['deleted'=> true]);
        return redirect(route('admin.nutzerverwaltung'))->with([
            'title' => 'Nutzerverwaltung',
            'message' => 'Account wurde deaktiviert.',
            'alertType'=> 'info'
        ]);
    }

    public function wakeUp(User $user)
    {
        $user->update(['deleted'=> false]);
        return redirect(route('admin.nutzerverwaltung'))->with([
            'title' => 'Nutzerverwaltung',
            'message' => 'Account wurde reaktiviert.',
            'alertType'=> 'info'
        ]);
    }


}

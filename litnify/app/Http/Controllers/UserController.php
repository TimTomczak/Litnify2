<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use App\Models\Berechtigungsrolle;
use App\Models\Merkliste;
use Carbon\Carbon;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\View\View;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Livewire\WithPagination;

class UserController extends Controller
{

    public function index()
    {

        $users = \App\Models\User::all(); //@todo Pagination
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
        User::create($request->validate([
            'nachname' => 'string',
            'vorname' => 'string',
            'email' => 'email',
        ]));

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
        return back()->with([
            'title' => 'Nutzerverwaltung',
            'message' => 'Account wurde geändert.',
            'alertType'=> 'info'
        ]);
    }

    public function destroy(User $user)
    {
        $user->deleted = true;
        $user->save();
        return back()->with([
            'title' => 'Nutzerverwaltung',
            'message' => 'Account wurde deaktiviert.',
            'alertType'=> 'info'
        ]);
    }

    public function wakeUp(User $user)
    {
        $user->deleted = false;
        $user->save();
        return back()->with([
            'title' => 'Nutzerverwaltung',
            'message' => 'Account wurde reaktiviert.',
            'alertType'=> 'info'
        ]);
    }



    public function createAvatar($name){
        $avatar = new InitialAvatar();
        return $avatar
            ->name(str_replace('+', ' ', $name))
            ->length(2)
            ->fontSize(0.5)
            ->size(150)
            ->background('#0F539D')
            ->color('#fff')
            ->font('/fonts/OpenSans-Bold.ttf')
            ->rounded()
            ->generate()
            ->stream('png', 100);
    }

    public function showProfil()
    {
        return view('user.profil', array('user' => Auth::user()));
    }

    public function showMerkliste(){
            return view('user.merkliste',[
                'user' => Auth::user(),
                'merkliste' => (Auth::user())->merkliste->paginate(15),
                'tableBuilder' => TableBuilder::$medienverwaltungIndex,
                'tableStyle' => TableBuilder::$tableStyle,
                'aktionenStyles' => TableBuilder::$aktionenStyles,
            ]);
    }

    public function editMerkliste(Request $request)
    {
        Merkliste::query()
           ->where('medium_id',$request->id)
           ->where('user_id', Auth::user()->id)
            ->FirstOrFail()
            ->delete();

       return redirect()->back();
    }


    public function showAusleihen()
    {
        return view('user.ausleihen', [
            'user' => Auth::user(),
            'ausleihe' => Auth::user()->ausleihe->paginate(15),
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'now' => Carbon::now()
        ]);
    }

    public function setShowCards(Request $request){
        if ($request->has('showCards')){
            $request->validate(
                ['showCards'=>Rule::in(['true','false'])]
            );
            session(['showCards' => $request->get('showCards')]);
        }
        return back();
    }
}

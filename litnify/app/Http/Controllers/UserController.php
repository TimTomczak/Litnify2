<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use App\Models\Berechtigungsrolle;
use App\Models\Merkliste;
use Carbon\Carbon;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Livewire\WithPagination;

class UserController extends Controller
{
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

    public function showProfil(){

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

    public function editMerkliste(Request $request){

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
}

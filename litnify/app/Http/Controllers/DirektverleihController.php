<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Inventarliste;
use App\Models\Medium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class DirektverleihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('Ausleihverwaltung/Direktverleih.index',[
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(User $user)
    {
        $medien=DB::table('medien_ausleihbar')->get()->toArray();

        $medien=Medium::hydrate($medien)->map(function($medium){
//            if ($medium->isAusleihbar()){
                return $medium;
//            }
        })->paginate(10);
//        $user_id=$request->validate(['user_id' => 'required|integer']);
        return view('Ausleihverwaltung/Direktverleih.create',[
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'user' => $user,
            'medien' => $medien,
            'ausleihdauerDefault' => 28 /*TODO ausleihDauer aus parameter übergeben */
        ]);
    }
}

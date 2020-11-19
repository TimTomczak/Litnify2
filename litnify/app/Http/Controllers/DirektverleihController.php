<?php

namespace App\Http\Controllers;

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
    public function create(Request $request)
    {
        $medien=DB::table('medien_ausleihbar')->get()->toArray();

        $medien=Medium::hydrate($medien)->filter(function($medium){
            if ($medium->isAusleihbar()){
                return $medium;
            }
        });

        $user_id=$request->validate(['user_id' => 'required|integer']);
        return view('Ausleihverwaltung/Direktverleih.create',[
            'user' => User::findOrFail($user_id)->first(),
            'medien' => $medien,
            'ausleihdauerDefault' => 28 /*TODO ausleihDauer aus parameter übergeben */
        ]);
    }
}

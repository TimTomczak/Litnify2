<?php

namespace App\Http\Controllers;

use App\Helpers\TableBuilder;
use App\Models\Medium;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DirektverleihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.ausleihverwaltung.direktverleih.index',[
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
        $medien=Medium::hydrate($medien)->map(function($medium){ return $medium; });

        return view('admin.ausleihverwaltung.direktverleih.create',[
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'user' => $user,
            'medien' => $medien->paginate(10),
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }
}

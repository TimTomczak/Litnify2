<?php

namespace App\Http\Controllers;

use App\Models\Inventarliste;
use App\Models\Medium;
use App\Models\User;
use Illuminate\Http\Request;
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
//        $medien = collect(DB::table('medien')
//            ->leftJoin('inventarliste', 'medien.id', '=', 'inventarliste.medium_id')
//            ->orderBy('medien.id','DESC')
//            ->where('medien.released',1)
//            ->where('medien.deleted',0)
//            ->where('inventarliste.ausleihbar',1)
//            ->limit(100)->get());
//        dd($medien);

//        $medien=Medium::with('inventarliste')
//            ->orderBy('medien.id','DESC')
//            ->where('medien.released',1)
//            ->where('medien.deleted',0)
//            ->get()->filter(function (Medium $med){
//                if ($med->isAusleihbar()){
//                    return $med;
//                }
//            });

        $medien=DB::table('medien_ausleihbar')->get()->toArray();
        $medien=Medium::hydrate($medien)->filter(function($medium){
            if ($medium->isAusleihbar()){
                return $medium;
            }
        });
//        $medien = Medium::limit(20)->get();

        $user_id=$request->validate(['user_id' => 'required|integer']);
        return view('Ausleihverwaltung/Direktverleih.create',[
            'user' => User::findOrFail($user_id)->first(),
            'medien' => $medien,
            'ausleihdauerDefault' => 28 /*TODO ausleihDauer aus parameter übergeben */
        ]);
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
}

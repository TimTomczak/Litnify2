<?php

namespace App\Http\Controllers;

use App\Helpers\extendedFilterSearch;
use App\Helpers\Helper;
use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class SearchController extends Controller
{
    public function index(Request $request){

        if ($request->has('ppr')){
            $request->validate([
                'ppr' => Rule::in([10,11,25,50,100])
            ]);
            $ppr=$request->ppr;
        }
        else{
            $ppr=10;
        }

        $result=Suche::getInstance()->search($request);
        $literaturartenCounter=Suche::getInstance()->countLiteraturarten($result);
        $result=extendedFilterSearch::getInstance()->extendedFilterSearch($request, $result);
        if (!$request->has('q')){
            $literaturartenCounter=Suche::getInstance()->countLiteraturarten($result);
        }

//        $request->session()->flash('old_query',$request->query());

        return view('search.suche', [
            'searchQuery' => $request->q,
            'result' => $result->isEmpty() ? false : $result->paginate($ppr),
            'request' => $request->query(),
            'litTypeCounter' => $literaturartenCounter,
            'tableBuilder' => TableBuilder::$sucheIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles
        ]);

    }

    /**
     * @param Request $request
     */
    public function show(Request $request)
    {

    }

    public function export(Request $request){
        dd($request->all());
    }



}

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
        Helper::getSuchFilterValue('a');

        if ($request->has('ppr')){
            $request->validate([
                'ppr' => Rule::in([10,25,50,100])
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

        /* Redirect ohne &page , wenn die Seitenzahl höher wäre, als die Anzahl der eigentlichen Suchtreffer*/

        if ($request->has('page')){
            if ($request->query('page')*10-10 > $result->count()){ // bspw. Paginator Seite 7 (Ergebnisse 61-70), aber nur 50 Ergebnisse
                return redirect(Helper::removeQueryStringParameters(['page'])); // Ergebnis ab Seite 1
            }
        }

        if (\Auth::check()){
            Cache::put(\Auth::user()->id.'-export',$result);
        }

        return view('search.suche', [
            'searchQuery' => $request->q,
            'auswahl' => Helper::$suchFilter,
            'result' => $result->isEmpty()  ? false : $result->paginate($ppr),
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

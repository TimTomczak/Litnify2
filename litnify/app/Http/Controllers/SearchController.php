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
                'ppr' => Rule::in([10,25,50,100])
            ]);
            $ppr=$request->ppr;
        }
        else{
            $ppr=10;
        }
        if (Cache::has($request->getRequestUri())){
            $result=Cache::get($request->getRequestUri());
            $literaturartenCounter=Cache::get($request->getRequestUri().'-litArtCounter');
        }
        else {
            $result = Suche::getInstance()->search($request);
            $literaturartenCounter = Suche::getInstance()->countLiteraturarten($result);
            $result = extendedFilterSearch::getInstance()->extendedFilterSearch($request, $result);

            if (!$request->has('q')) {
                $literaturartenCounter = Suche::getInstance()->countLiteraturarten($result);
            }

            Cache::put($request->getRequestUri(), $result, now()->addMinutes(30));
            Cache::put($request->getRequestUri().'-litArtCounter', $literaturartenCounter, now()->addMinutes(30));
        }
        /* Redirect ohne &page , wenn die Seitenzahl höher wäre, als die Anzahl der eigentlichen Suchtreffer*/
        if ($request->has('page')){
            if ($request->query('page')*10-10 > $result->count()){ // bspw. Paginator Seite 7 (Ergebnisse 61-70), aber nur 50 Ergebnisse
                return redirect(Helper::removeQueryStringParameters(['page'])); // Ergebnis ab Seite 1
            }
        }

        /* Sortieren nur nach angezeigten Spalten in der View (TableBuilder::$sucheIndex) und Relevanz */
        if ($request->has('sort')){
            $sort=$request->get('sort');
            if (array_key_exists($sort,TableBuilder::$sucheIndex)) {
                if ($request->has('direction')) {
                    $direction = $request->get('direction');
                    if ($direction == 'asc') {
                        $result = $result->sortBy($sort);
                    } elseif ($direction == 'desc') {
                        $result = $result->sortByDesc($sort);
                    }
                }
            }
            elseif($sort=='relevanz'){
                $result = $result->sortByDesc($sort);
            }
        }
//        dd($result->load('literaturart'));
        return view('search.suche', [
            'searchQuery' => $request->q,
            'auswahl' => Helper::$suchFilter,
            'result' => $result->isEmpty()  ? false : $result->load('literaturart','raum','zeitschrift')->paginate($ppr),
            'request' => $request->query(),
            'litTypeCounter' => $literaturartenCounter,
            'tableBuilder' => TableBuilder::$sucheIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'exportData' => $result->isEmpty()  ? $result->toArray() : $result->paginate($ppr)->items(),
            'exportCols' => TableBuilder::$mediumShow,
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

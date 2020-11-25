<?php


namespace App\Helpers;


use App\Models\Inventarliste;
use App\Models\Literaturart;
use App\Models\Medium;
use App\Models\Zeitschrift;

class Suche
{
    private static $instance = null;

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {
    }

    private $searchFilters=[
        'all',
        'name',
        'titel',
        'sign',
        'isbn',
        'issn',
        'ztitel',
        'invnr',
    ];

    private $extendedSearchFilters=[
        'dateFrom',
        'dateTo',
        'type' => [
            'artikel' => 1,
            'buch' => 2,
            'graulit' => 3,
            'unwerk' => 4,
            'daten' => 5,
        ]
    ];


    /**
     * Sucht anhand des übergebenen Arrays von Parametern entsprechend der Filter im Model Medium
     *
     * @param $searchQueryArray (Array von request()->all())
     * @return $result -> Suchergebis als Collection von Medien
     */
    public function search($request){
        if (empty($request->query())){                                                              // Falls keine Parameter übergeben wurden (also nur /suche aufgerufen wurde)
            return $result=collect();                                                               // Kein Suchergebnis gefunden -> leere Collection
        }
        else{                                                                                       // ... ,ansonsten
            if ($request->has('q')){                                                                // prüfen, ob ein Suchstring q übergeben wurde
                if ($request->has('filter')){                                                       // Falls spezialisierte Suche nach Filter
                    if (array_key_exists($request->filter, array_flip($this->searchFilters))){   // Wenn Filter nicht existiert -> überspringen
                        $result=$this->filterSearch($request->query());                             // -> filterSearch aufrufen
                    }
                    else{
                        $result=collect();
                    }
                }
                else{
                    $result=$this->initSearch($request->q);                                         // Ansonsten initSearch aufrufen
                }
            }
            else{
                $result=collect();                                                                  // Kein Suchbegriff eingegeben
            }
        }

        if (!empty($request->only($this->extendedSearchFilters))){
            foreach ($request->only($this->extendedSearchFilters) as $extendedSearchFilter => $parameter){
                $result=$this->extendedSearch($result,$extendedSearchFilter,$parameter);
            }
        }

        /* Typsuche gesondert */
        //  Array der IDs aller gesuchten Literaturarten erstellen, mit dem dann mittels whereIn gefiltert werden kann
        $typeSearch=[];
        foreach ($this->extendedSearchFilters['type'] as $type => $id) {
            if (array_key_exists($type, $request->query())) {
                array_push($typeSearch, $id);
            }
        }

        if (!empty($typeSearch)){                                                   // prüfen, ob überhaupt ein Typ-Filter vorhanden ist
            $result=$this->extendedSearch($result,'type',$typeSearch);
        }

        return $result;
    }

    /**
     * Durchsucht das Model Medium mittels MySQL Driver in einer BOOLschen FULL TEXT Suche
     *
     * @param $searchString
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function initSearch($searchString){
        return Medium::search($searchString)
            ->get()
            ->where('released',1)
            ->where('deleted',0);
    }

    /**
     * Durchsucht Medien anhand der angegebenen Filter
     *
     * @param $searchQueryArray
     * @return Medium[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function filterSearch($searchQueryArray){
        $searchQuery=$searchQueryArray['q'];
        switch ($searchQueryArray['filter']){
            case 'all':
                $result=$this->initSearch($searchQuery);
                break;
            case 'name':
                $result=Medium::with('literaturart')->where('autoren','like','%'.$searchQuery.'%')
                    ->orWhere('herausgeber','like','%'.$searchQuery.'%')
                    ->orWhere('institut','like','%'.$searchQuery.'%')
                    ->get();
                break;
            case 'titel':
                $result=Medium::with('literaturart')->where('hauptsachtitel','like','%'.$searchQuery.'%')->get();
                break;
            case 'sign':
                $result=Medium::with('literaturart')->where('signatur','like','%'.$searchQuery.'%')->get();
                break;
            case 'isbn':
                $result=Medium::with('literaturart')->where('isbn','like','%'.$searchQuery.'%')->get();
                break;
            case 'issn':
                $result=Medium::with('literaturart')->where('issn','like','%'.$searchQuery.'%')->get();
                break;
            case 'ztitel':
                $zeit=Zeitschrift::where('name','like','%'.$searchQuery.'%')->with(['medium' => function ($query) {
                    $query->where('released',1)->where('deleted',0);
                }]);
                $result=Medium::with('literaturart')->whereIn('zeitschrift_id',$zeit->pluck('id')->all())->get();
                break;
            case 'invnr':
                $inv=Inventarliste::whereInventarnummer($searchQuery)->with(['medium' => function ($query) {
                    $query->where('released',1)->where('deleted',0);
                }]);
                $result=Medium::with('literaturart')->whereIn('id',$inv->pluck('medium_id')->all())->get();
                break;
        }
        return $result->where('released',1)->where('deleted',0)->sortByDesc('id');
    }

    private function extendedSearch($result,$searchFilter,$parameter){
        switch ($searchFilter){
            case 'dateFrom':
                if ($parameter!=null){
                    $parameter-=1;
                    $result->isEmpty() ?
                        $result=Medium::with('literaturart')->where('jahr','>',$parameter)->get() :
                        $result=$result->where('jahr','>',$parameter);
                }
                break;

            case 'dateTo':
                if ($parameter!=null) {
                    $parameter += 1;
                    $result->isEmpty() ?
                        $result = Medium::with('literaturart')->where('jahr', '<', $parameter)->get() :
                        $result = $result->where('jahr', '<', $parameter);
                }
                break;

            case 'typeBuch'||'typeArtikel':
                $result->isEmpty() ?
                    $result=Medium::with('literaturart')->whereIn('literaturart_id',$parameter)->get() :
                    $result=$result->whereIn('literaturart_id',$parameter);
                break;
        }
        return $result->where('released',1)->where('deleted',0);
    }
}

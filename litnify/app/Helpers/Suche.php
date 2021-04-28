<?php


namespace App\Helpers;


use App\Models\Ausleihe;
use App\Models\Berechtigungsrolle;
use App\Models\Inventarliste;
use App\Models\Literaturart;
use App\Models\Medium;
use App\Models\User;
use App\Models\Zeitschrift;
use Illuminate\Support\Facades\DB;

/**
 * Class Suche
 * @package App\Helpers
 */
class Suche
{
    /**
     * @var null
     */
    private static $instance = null;


    /**
     * @return Suche
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

    /**
     * @var string[]
     */
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
                    if ($request->filter===null){
                        unset($request['filter']);
                        return $this->search($request);
                    }

                    $request->validate(
                        ['q' => 'min:3'],
                        ['min' => 'Die Suche muss aus mindestens 3 Zeichen bestehen.']
                    );
                    if (array_key_exists($request->filter, array_flip($this->searchFilters))){      // Wenn Filter nicht existiert -> überspringen
                        $result=$this->filterSearch($request->query());                             // -> extendedFilterSearch aufrufen
                    }
                    else{
                        $result=collect();
                    }
                }
                else{
                    if ($request->q===null){
                        $result=collect();
                    }
                    else{
                        $request->validate(
                            ['q' => 'min:3'],
                            ['min' => 'Die Suche muss aus mindestens 3 Zeichen bestehen.']
                        );
                        $result=$this->initSearch($request->q);                                         // Ansonsten initSearch aufrufen
                    }
                }
            }
            else{
                $result=collect();                                                                  // Kein Suchbegriff eingegeben
            }
        }
        return $result;
    }

    /**
     * Durchsucht das Model Medium mittels MySQL Driver in einer BOOLschen FULL TEXT Suche
     *
     * @param $searchString
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function initSearch($searchString){
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
    protected function filterSearch($searchQueryArray){
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
                $inv=Inventarliste::where('inventarnummer','like','%'.$searchQuery.'%')->with(['medium' => function ($query) {
                    $query->where('released',1)->where('deleted',0);
                }]);
                $result=Medium::with('literaturart')->whereIn('id',$inv->pluck('medium_id')->all())->get();
                break;
        }
        return $result->where('released',1)->where('deleted',0)->sortByDesc('id');
    }

    /**
     * @param $result
     * @param $searchFilter
     * @param $parameter
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function extendedSearch($result, $searchFilter, $parameter, $request){
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

            case 'type':
                $result->isEmpty()&&!$request->has('q')?
                    $result=Medium::with('literaturart')->whereIn('literaturart_id',$parameter)->get() :
                    $result=$result->whereIn('literaturart_id',$parameter);
                break;

            case 'onlyBorrowable':
                $mediumIdsAusleihbar=DB::table('medien_ausleihbar')->distinct('medium_id')->pluck('medium_id');
                $result->isEmpty() ?
                    $result=Medium::whereIn('id',$mediumIdsAusleihbar)->get() :
                    $result=$result->whereIn('id',$mediumIdsAusleihbar);
                break;
        }
        return $result->where('released',1)->where('deleted',0);
    }


    /**
     * @param $result
     * @return array
     */
    public function countLiteraturarten($result)
    {
        return $literaturartenCounter = [
            'artikel' => $result->where('literaturart_id', 1)->count(),
            'buch' => $result->where('literaturart_id', 2)->count(),
            'graulit' => $result->where('literaturart_id', 3)->count(),
            'unwerk' => $result->where('literaturart_id', 4)->count(),
            'daten' => $result->where('literaturart_id', 5)->count(),
        ];
    }

    public function searchMedien($searchQuery){

        $literaturart=Literaturart::where('literaturart','like','%'.$searchQuery.'%')->get();
        if ($literaturart->isNotEmpty()){
            return Medium::with('literaturart')->whereIn('literaturart_id',$literaturart->pluck('id'))->where('deleted',0)->where('released',1);
        }
        else{
            $medien=Medium::where('id','like','%'.$searchQuery.'%')
                ->orWhere('signatur','like','%'.$searchQuery.'%')
                ->orWhere('autoren','like','%'.$searchQuery.'%')
                ->orWhere('hauptsachtitel','like','%'.$searchQuery.'%')
                ->orWhere('untertitel','like','%'.$searchQuery.'%')
                ->orWhere('enthalten_in','like','%'.$searchQuery.'%')
                ->orWhere('erscheinungsort','like','%'.$searchQuery.'%')
                ->orWhere('jahr','like','%'.$searchQuery.'%')
                ->orWhere('verlag','like','%'.$searchQuery.'%')
                ->orWhere('isbn','like','%'.$searchQuery.'%')
                ->orWhere('issn','like','%'.$searchQuery.'%')
                ->orWhere('doi','like','%'.$searchQuery.'%')
                ->orWhere('auflage','like','%'.$searchQuery.'%')
                ->orWhere('herausgeber','like','%'.$searchQuery.'%')
                ->orWhere('schriftenreihe','like','%'.$searchQuery.'%')
                ->orWhere('band','like','%'.$searchQuery.'%')
                ->orWhere('institut','like','%'.$searchQuery.'%')
                ->orWhere('bemerkungen','like','%'.$searchQuery.'%');
            return $medien;
        }
    }

    /**
     * @param $searchQuery
     * @return Berechtigungsrolle[]|User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function searchUsers($searchQuery){
        if(Berechtigungsrolle::with('user')->where('berechtigungsrolle','like','%'.$searchQuery.'%')->get()->isNotEmpty()){
            return $result=Berechtigungsrolle::with('user')->where('berechtigungsrolle','like','%'.$searchQuery.'%')
                ->get()
                ->map(function ($rolle){
                    return $rolle->user;
                })->flatten();
        }
        else {
            try {
                if (strtotime($searchQuery)) {
                    $dbDate = date('Y-m-d', strtotime($searchQuery));
                    return $result = User::with('berechtigungsrolle')->where('created_at', 'like', '%' . $dbDate . '%')->get();
                }
                else{
                    throw new \ErrorException();
                }
            }
            catch(\ErrorException $e){
                return $result=User::where('email','like','%'.$searchQuery.'%')
                    ->orWhere('nachname','like','%'.$searchQuery.'%')
                    ->orWhere('vorname','like','%'.$searchQuery.'%')
                    ->orWhere('uid','like','%'.$searchQuery.'%')->get()->load('berechtigungsrolle');
            }
        }
    }

    /**
     * @param $searchQuery
     * @return Zeitschrift|\Illuminate\Database\Eloquent\Builder
     */
    public function searchZeitschriften($searchQuery){
        return Zeitschrift::where('name','like','%'.$searchQuery.'%')
            ->orWhere('shortcut','like','%'.$searchQuery.'%')
            ->orWhere('id','like','%'.$searchQuery.'%');
    }

    public function searchAusleihen($searchQuery){
        if (filter_var($searchQuery, FILTER_VALIDATE_INT)!==false){
            return Ausleihe::where('id',$searchQuery)
                ->orWhere('user_id',$searchQuery)
                ->orWhere('medium_id',$searchQuery)
                ->orWhere('Verlaengerungen',$searchQuery);
        }
        elseif (strtotime($searchQuery)){
            $searchQuery=date('Y-m-d',strtotime($searchQuery));
            return Ausleihe::where('Ausleihdatum','like','%'.$searchQuery.'%')
                ->orWhere('RueckgabeSoll','like','%'.$searchQuery.'%')
                ->orWhere('RueckgabeIst','like','%'.$searchQuery.'%');
        }
        else{

            return Ausleihe::where('inventarnummer','like','%'.$searchQuery.'%');
        }
    }
}

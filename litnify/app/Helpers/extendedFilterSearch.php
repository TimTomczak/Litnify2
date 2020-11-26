<?php


namespace App\Helpers;


class extendedFilterSearch extends Suche
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

    public function extendedFilterSearch($request, $result){
        if (!empty($request->only($this->extendedSearchFilters))){
            foreach ($request->only($this->extendedSearchFilters) as $extendedSearchFilter => $parameter){
                $result=$this->extendedSearch($result,$extendedSearchFilter,$parameter,$request);
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
            $result=$this->extendedSearch($result,'type',$typeSearch,$request);
        }

        return $result;
    }
}

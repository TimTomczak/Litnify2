<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Helper
{
    private static $literaturart_attribute=[
        'Artikel' => ['literaturart_id','autoren','hauptsachtitel','untertitel','jahr','issn','doi','zeitschrift_id','band','seite','raum_id','bemerkungen'],
        'Buch' => ['literaturart_id','signatur','autoren','hauptsachtitel','untertitel','erscheinungsort','jahr','verlag','isbn','issn','inventarnummern','auflage','herausgeber','schriftenreihe','band','seite','raum_id','bemerkungen'],
        'Graue Literatur' => ['literaturart_id','signatur','autoren','hauptsachtitel','untertitel','erscheinungsort','jahr','verlag','isbn','issn','inventarnummern','auflage','herausgeber','schriftenreihe','band','seite','institut','raum_id','bemerkungen'],
        'Unselbstständiges Werk' => ['literaturart_id','signatur','autoren','hauptsachtitel','untertitel','enthalten_in','erscheinungsort','jahr','verlag','isbn','issn','inventarnummern','auflage','herausgeber','schriftenreihe','band','seite','raum_id','bemerkungen'],
        'Daten' => ['literaturart_id','autoren','hauptsachtitel','untertitel','erscheinungsort','jahr','verlag','issn','herausgeber','schriftenreihe','band','seite','institut','raum_id','bemerkungen'],
    ];

    public static $suchFilter=[
        array('short' => 'all',     'full' => 'Alle Felder'),
        array('short' => 'name',    'full' => 'Name (Autor, Hrsg.)'),
        array('short' => 'titel',   'full' => 'Titel'),
        array('short' => 'sign',    'full' => 'Signatur'),
        array('short' => 'isbn',    'full' => 'ISBN'),
        array('short' => 'issn',    'full' => 'ISSN'),
        array('short' => 'ztitel',  'full' => 'Zeitschriftentitel'),
        array('short' => 'invnr',   'full' => 'Inventar-Nr.'),
    ];

    public static $literaturartenIcons=[
        'null' => '',
        1 => 'fa fa-file-text-o',
        2 => 'fa fa-book' ,
        3 => 'fa fa-newspaper-o' ,
        4 => 'fa fa-files-o' ,
        5 => 'fa fa-floppy-o'
    ];

    static function getSuchFilterValue($key){
       foreach (self::$suchFilter as $filter){
           if ($filter['short'] == $key){
               return $filter['full'];
           }
       }
       return false;
    }

    static function sidebar_active($path) {
        return call_user_func_array('Request::is', (array)$path) ? 'active' : 'bg-light';
    }

    static function tab_active($tab) {
        return (Request::query('seite') == $tab) ? 'active' : 'false' ;
    }

    static function getQueryStringParameters($parameter)
    {
        return request()->has('filter') ? request()->query('filter') : '';
    }

    static function addQueryStringParameters(array $parameters = [])
    {
        $query = array_merge(
            request()->query(),
            $parameters
        );
        return url()->current() . '?' . http_build_query($query);
    }

    static function removeQueryStringParameters(array $parameters = [])
    {
        $url = url()->current();
        $query = request()->query();
        foreach($parameters as $param) {
            unset($query[$param]);
        }
        return $query ? $url . '?' . http_build_query($query) : $url;
    }

    static function updateQueryStringParameters(array $parameters = [])
    {
        $url = url()->current();
        $query = request()->query();
        foreach ($query as $queryKey => $queryParam){
            foreach($parameters as $paramKey => $param) {
                $query[$queryKey] = $queryKey==$paramKey ? $param : $queryParam;
            }
        }
        return $query ? $url . '?' . http_build_query($query) : $url;
    }

    public static function parseSqlAddPrefix($pathToFile){
        $txt_file    = file_get_contents($pathToFile);
        $rows        = explode("\n", $txt_file);
        foreach($rows as $row => $data)
        {
            if (strpos($data,'INSERT INTO')!==false){
                $data=substr_replace($data,env('DB_TABLE_PREFIX', 'laravel'),strpos($data,"`")+1,0);
                $rows[$row]=$data;
            }
        }
        return implode("\n",$rows);
    }

    /**
     * Bekommt die File Contents einer großen SQL-Datei und gibt ein array der INSERTS wieder
     *
     * @param $file_content
     * @return false|string[]
     */
    public static function chunkSql($file_content){
        $chunks = explode("INSERT", $file_content);
        array_shift($chunks);
        foreach($chunks as $chunk => $chunk_data)
        {
            $data = substr_replace($chunk_data,'INSERT',0,0);
            $chunks[$chunk]=$data;
        }
        return $chunks;
    }

    public static function showCards(){
        if (request()->session()->has('showCards')){
            return request()->session()->get('showCards');
        }else{
            return 'true';
        }
    }

    public static function showField($attribute_name,$literaturart){
        return in_array($attribute_name, self::$literaturart_attribute[$literaturart]);
    }

}

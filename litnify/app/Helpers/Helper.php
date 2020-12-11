<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Helper
{
    static function sidebar_active($path) {
        return call_user_func_array('Request::is', (array)$path) ? 'active' : 'bg-light';
    }

    static function tab_active($tab) {
        return (Request::query('seite') == $tab) ? 'active' : 'false' ;
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

}

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

}

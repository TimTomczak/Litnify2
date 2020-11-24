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
}

<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    static function sidebar_active($path) {

        return call_user_func_array('Request::is', (array)$path) ? 'active' : 'bg-light';


    }
}

<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getNextAutoincrement(string $tableName){
        $statement = DB::select("SHOW TABLE STATUS LIKE '".env('DB_TABLE_PREFIX', 'laravel').$tableName."'");
        if (empty($statement)){
            throw new Exception('Tabelle "'.env('DB_TABLE_PREFIX', 'laravel').$tableName.'" nicht vorhanden.');
        }
        return $statement[0]->Auto_increment;
    }
}

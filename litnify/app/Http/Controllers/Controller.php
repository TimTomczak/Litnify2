<?php

namespace App\Http\Controllers;

use App\Models\Literaturart;
use App\Models\Raum;
use App\Models\Zeitschrift;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function mapForeignKeyReferences($medien){
        $mappedLiteraturart = $this->mapLiteraturart($medien);
        $mappedRaum = $this->mapRaum($mappedLiteraturart);
        $mappedZeitschrift = $this->mapZeitschrift($mappedRaum);

        return $mappedZeitschrift;
    }

    private function mapLiteraturart($medien){
        $mapped = $medien->map(function($item){
            if ($item->literaturart_id!=null){
                $item->literaturart_id=Literaturart::find($item->literaturart_id)->literaturart;
            }
            return $item;
        });
        return $mapped;
    }

    private function mapRaum($medien){
        $mapped = $medien->map(function($item){
            if ($item->raum_id!=null){
                $item->raum_id=Raum::find($item->raum_id)->raum;
            }
            return $item;
        });
        return $mapped;
    }

    private function mapZeitschrift($medien){
        $mapped = $medien->map(function($item){
            if ($item->zeitschrift_id!=null){
                $item->zeitschrift_id=Zeitschrift::find($item->zeitschrift_id)->name;
            }
            return $item;
        });
        return $mapped;
    }
}

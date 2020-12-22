<?php

namespace App\Exports;

use App\Models\Ausleihe;
use App\Models\Medium;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\FromCollection;

class MediumExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cache::get(\Auth::user()->id.'-export');
//        return Ausleihe::all();
    }
}

<?php

namespace App\Exports;

use App\Models\Ausleihe;
use App\Models\Medium;
use Maatwebsite\Excel\Concerns\FromCollection;

class MediumExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ausleihe::all();
    }
}

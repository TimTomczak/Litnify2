<?php

namespace App\Exports;

use App\Helpers\TableBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MerklisteExport implements FromView
{

    public function view(): View
    {
        return view('export.merkliste',[
            'user' => Auth::user(),
            'merkliste' => (Auth::user())->merkliste,
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }
}

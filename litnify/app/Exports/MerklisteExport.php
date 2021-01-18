<?php

namespace App\Exports;

use App\Helpers\TableBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class MerklisteExport implements FromView
{

    public function view(): View
    {
        return view('user.merkliste',[
            'merkliste' => (Auth::user())->merkliste

        ]);
    }
}

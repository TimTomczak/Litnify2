<?php

namespace App\Http\Livewire;

use App\Models\Medium;
use Livewire\Component;

class AddSystematikgruppeComponent extends Component
{
    public $i=0;//Anzahl an Namen
    public $inputs=[];

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        return view('livewire.add-systematikgruppe-component',[
            'systematikgruppen'=>Medium::distinct('signatur')->orderBy('signatur')->pluck('signatur'),
        ]);
    }
}

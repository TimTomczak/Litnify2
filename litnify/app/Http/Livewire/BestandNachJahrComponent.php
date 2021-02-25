<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Medium;
use Livewire\Component;

class BestandNachJahrComponent extends Component
{
    public $literaturart;
    public $jahr;
    protected $result;

    public function render()
    {
        $this->searchMedienByJahr();
        return view('livewire.bestand-nach-jahr-component',[
            'aktionenStyles'=>TableBuilder::$aktionenStyles,
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'exportData' => $this->result->toArray(),
            'result' => $this->result,
        ]);
    }

    private function searchMedienByJahr(){
        if (isset($this->jahr)&&isset($this->literaturart)){
            $this->result=Medium::where('literaturart_id',$this->literaturart)->where('jahr','like','%'.$this->jahr.'%')->get()->sortBy('signatur');
        }else{
            $this->result=collect();
        }
        $this->emit('rerenderPanel',$this->result);
    }
}

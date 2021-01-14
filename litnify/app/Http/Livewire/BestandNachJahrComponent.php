<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Medium;
use Livewire\Component;

class BestandNachJahrComponent extends Component
{
    public $literaturart;
    public $jahr;
    public $result;

    public function render()
    {
        $this->searchMedienByJahr();
        return view('livewire.bestand-nach-jahr-component',['aktionenStyles'=>TableBuilder::$aktionenStyles]);
    }

    private function searchMedienByJahr(){
        if (isset($this->jahr)&&isset($this->literaturart)){
            $this->result=Medium::where('literaturart_id',$this->literaturart)->where('jahr','like','%'.$this->jahr.'%')->get()->sortBy('signatur');
        }else{
            $this->result=collect();
        }
    }
}

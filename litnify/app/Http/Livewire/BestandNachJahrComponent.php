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
        if ($this->literaturart=="2"){
            $tableBuilder=TableBuilder::$bestandNachSystematikgruppenBuch;
        }
        else{
            $tableBuilder=TableBuilder::$medienverwaltungIndex;
        }

        return view('livewire.bestand-nach-jahr-component',[
            'aktionenStyles'=>TableBuilder::$aktionenStyles,
            'tableBuilder' => $tableBuilder,
            'exportData' => $this->result->toArray(),
            'result' => $this->result,
        ]);
    }

    private function searchMedienByJahr(){
        if (isset($this->jahr)&&isset($this->literaturart)){
            if ($this->literaturart=="2"){
                $this->result=Medium::with('inventarliste:inventarnummer')->where('literaturart_id',$this->literaturart)->where('jahr','like','%'.$this->jahr.'%')->get()->sortBy('signatur');
                $this->result=$this->result->map(function($med){
                    $mediumInventarnummernAsArray=$med->inventarliste->pluck('inventarnummer')->toArray();
                    $med->inventarnummer = implode(', ',$mediumInventarnummernAsArray);
                    return $med;
                });
            }
            else{
                $this->result=Medium::where('literaturart_id',$this->literaturart)->where('jahr','like','%'.$this->jahr.'%')->get()->sortBy('signatur');
            }

        }else{
            $this->result=collect();
        }
        $this->emit('rerenderPanel',$this->result);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Inventarliste;
use App\Models\Medium;
use Livewire\Component;

class AutorenComponent extends Component
{
    public $medium;
    public $i=0;//Anzahl an Namen
    public $inputs=[];
    public $message;
    public $autoren;
    public $autorenOld; //wird bei edit übergeben, falls bei Validierung Fehler auftreten
    public $autorRemoved=false;
    public $et_al=false;

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

    public function removeAutor($i)
    {
        unset($this->autoren[$i]);
        $this->autorRemoved=true;
        $this->emit('refresh');
    }

    public function render()
    {
        if (isset($this->medium)){
            if ($this->autorRemoved==false){
                $this->autoren=explode(';',$this->medium->autoren);
            }

            if ($this->i<count( $this->autoren) ){
                $this->i+=count( $this->autoren)-1;
            }
        }
        else{
            if(isset($this->autorenOld)){
                $this->autoren=explode(';',$this->autorenOld);
            }
        }
        return view('livewire.autoren-component',[
        ]);
    }
}

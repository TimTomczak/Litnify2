<?php

namespace App\Http\Livewire;

use App\Models\Inventarliste;
use App\Models\Medium;
use Livewire\Component;

class AutorenComponent extends Component
{
    public Medium $medium;
    public $i=0;//Anzahl an Namen
    public $inputs=[];
    public $message;
    public $autoren;
    public $autorRemoved=false;

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

    /*TODO Et_Al hinzufügbar machen*/
    public function render()
    {
        if ($this->autorRemoved==false){
            $this->autoren=explode(';',$this->medium->autoren);
        }

        if ($this->i<count( $this->autoren) ){
            $this->i+=count( $this->autoren)-1;
        }
        return view('livewire.autoren-component',[
        ]);
    }
}

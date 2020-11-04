<?php

namespace App\Http\Livewire;

use App\Models\Inventarliste;
use App\Models\Medium;
use Livewire\Component;

class InventarnummernComponent extends Component
{
    public Medium $medium;
    public $i=0;//Anzahl an Namen
    public $inputs=[];
    public $message;
    public $inventarnummer=[], $isb=[], $ausleihbar=[];
    public $inventarliste;

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
        if ($this->i<$this->medium->inventarliste->count()){
            $this->i+=$this->medium->inventarliste->count()-1;
        }

        $this->inventarliste=$this->medium->inventarliste->where('deleted','0');
        return view('livewire.inventarnummern-component',[
        ]);
    }

    public function destroy(Inventarliste $inventarliste){
        $inventarliste->update(['deleted'=>1]);
        $this->emit('refresh');
    }

    public function save(){
        foreach ($this->isb as $key=>$val) {
            $val==true ? $this->isb[$key]=1 : $this->isb[$key]=0;
        }
        foreach ($this->ausleihbar as $key=>$val) {
            $val==true ? $this->ausleihbar[$key]=1 : $this->ausleihbar[$key]=0;
        }

        $this->validateAttributes();
        foreach ($this->inputs as $key=>$val){
            $inv=Inventarliste::create([
                'medium_id'=>$this->medium->id,
                'inventarnummer' => $this->inventarnummer[$val],
                'isb' => isset($this->isb[$val]) ? $this->isb[$val] : 0,
                'ausleihbar' => isset($this->ausleihbar[$val]) ? $this->ausleihbar[$val] : 0,
            ]);
            $inv->medium()->attach($this->medium->id);
        }
        $this->resetParamenters();
        $this->message="Inventarnummer erfolgreich erstellt.";
        $this->emit('refresh');
    }

    private function resetParamenters(){
        $this->inputs=[];
        $this->inventarnummer=[];
        $this->ausleihbar=[];
        $this->isb=[];
    }

    public function updateIsb(Inventarliste $inventarliste){

        if ($inventarliste->isb==1){
            $inventarliste->update(['isb'=>0]);
        }
        else{
            $inventarliste->update(['isb'=>1]);
            if ($inventarliste->ausleihbar==0){
                $inventarliste->update(['ausleihbar'=>1]);
            }
        }
        $this->emit('refresh');
    }

    public function updateAusleihbar(Inventarliste $inventarliste){
        if ($inventarliste->ausleihbar==1){
            $inventarliste->update(['ausleihbar'=>0]);
            if ($inventarliste->isb==1) {
                $inventarliste->update(['isb' => 0]);
            }
        }
        else{
            $inventarliste->update(['ausleihbar'=>1]);
        }
        $this->emit('refresh');
    }

    private function validateAttributes(){
        $validatedAttributes = $this->validate([
            'inventarnummer.*' => 'required|string',
            'isb.*' => 'required|integer|between:0,1',
            'ausleihbar.*' => 'required|integer|between:0,1'
        ]);
        return $validatedAttributes;
    }
}

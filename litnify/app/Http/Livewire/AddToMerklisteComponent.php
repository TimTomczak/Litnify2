<?php

namespace App\Http\Livewire;

use App\Models\Medium;
use App\Models\Merkliste;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToMerklisteComponent extends Component
{
    public $medium;
    public $aufMerkliste=false;
    public $isAusleihbar=false;

    public function render()
    {
        if (Auth::check()) {
            if ($this->isMediumAufMerkliste()) {
                $this->aufMerkliste = true;
            }else{
                $this->isAusleihbar();
            }

        }
        return view('livewire.add-to-merkliste-component');
    }

    public function add2Merkliste(){
        $medium=$this->medium;
        if (Auth::check()){
            if ($this->isMediumAufMerkliste()==false){
                Merkliste::create([
                    'medium_id'=>$medium,
                    'user_id'=>Auth::user()->id
                ]);
                $this->aufMerkliste=true;
            }
        }
    }

    private function isMediumAufMerkliste(){
        return Merkliste::where('user_id',Auth::user()->id)->where('medium_id',$this->medium)
            ->get()
            ->isEmpty() ? false : true;
    }

    private function isAusleihbar(){
        if (Medium::findOrFail($this->medium)->isAusleihbar()){
            $this->isAusleihbar=true;
        }
    }

}

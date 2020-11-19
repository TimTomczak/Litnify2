<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Controller;
use App\Models\Zeitschrift;
use Livewire\Component;

class UpdateZeitschriftComponent extends Component
{
    public $zeitschrift;
    public $zeitschrift_id;
    public $name;
    public $shortcut;
    public $message;

    protected $rules=[
        'zeitschrift_id' => 'required|integer',
        'name' => 'required|string',
        'shortcut' => 'required|string'
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $this->zeitschrift_id=$this->zeitschrift->id;
        $this->name=$this->zeitschrift->name;
        $this->shortcut=$this->zeitschrift->shortcut;
        return view('livewire.update-zeitschrift-component');
    }

    public function submitForm(){
        $tmpName=$this->zeitschrift->name;

        $tmpShortcut=$this->zeitschrift->shortcut;
        $this->zeitschrift->update($this->validate());
        $this->message='';
        if ($tmpName!==$this->name){
            $this->message.='Der Name "'.$tmpName.'" wurde erfolgreich in "'.$this->name.'" geändert. ';
        }else{
            $this->message='';
        }
        if ($tmpShortcut!==$this->shortcut){
            $this->message.='Das Kürzel "'.$tmpShortcut.'" wurde erfolgreich in "'.$this->shortcut.'" geändert. ';
        }
        else{
            if ($tmpName===$this->name){
                $this->message='';
            }
        }
    }

}

<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Controller;
use App\Models\Zeitschrift;
use Livewire\Component;

class CreateZeitschriftForm extends Component
{
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
        return view('livewire.create-zeitschrift-form',[
            'nextId' => Controller::getNextAutoincrement('zeitschriften')
        ]);
    }

    public function submitForm(){
        $zeitschrift = Zeitschrift::create($this->validateAttributes());
        $this->resetForm();
        $this->message='Die neue Zeitschrift "'.$zeitschrift->name.'" wurde gespeichert.';
    }

    private function resetForm(){
        $this->zeitschrift_id=Controller::getNextAutoincrement('zeitschriften');
        $this->name='';
        $this->shortcut='';
        $this->message='';
    }

    public function validateAttributes(){
        $this->zeitschrift_id=Controller::getNextAutoincrement('zeitschriften');
        $validatedAttributes = $this->validate();
        return $validatedAttributes;
    }
}

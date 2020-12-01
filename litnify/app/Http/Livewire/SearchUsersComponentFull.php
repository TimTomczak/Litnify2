<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Berechtigungsrolle;
use App\Models\User;
use Livewire\Component;

class SearchUsersComponentFull extends Component
{
    public $searchQuery;

    public function render()
    {

        if ($this->hasSpecialChars($this->searchQuery)==1){
            $users=User::where('email','like','%'.$this->searchQuery.'%')->paginate(10);
        }
        elseif(Berechtigungsrolle::where('berechtigungsrolle','like','%'.$this->searchQuery.'%')->get()->isNotEmpty()){
            $users=Berechtigungsrolle::where('berechtigungsrolle','like','%'.$this->searchQuery.'%')
                ->get()
                ->map(function ($rolle){
                    return $rolle->user;
                })->flatten()->paginate(10);
        }
        else {
            $users = User::search($this->searchQuery)->paginate(10);
        }
        return view('livewire.search-users-component-full',[
            'users' => $users,
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }

    private function hasSpecialChars($string){
        return preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $string);//[@_!#$%^&*()<>?/|}{~:]
    }

    private function hasRolle($string){

    }
}

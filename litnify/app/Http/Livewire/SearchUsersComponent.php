<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Berechtigungsrolle;
use App\Models\User;
use Livewire\Component;

class SearchUsersComponent extends Component
{
    public $searchQuery;

    public function render()
    {

        if ($this->hasSpecialChars($this->searchQuery)==1){
            try {
                $dbDate=date('Y-m-d',strtotime($this->searchQuery));
                $users=User::where('created_at','like','%'.$dbDate.'%');
            }
            catch(\ErrorException $e){
                $users=User::where('email','like','%'.$this->searchQuery.'%');
            }
        }
        elseif(Berechtigungsrolle::where('berechtigungsrolle','like','%'.$this->searchQuery.'%')->get()->isNotEmpty()){
            $users=Berechtigungsrolle::where('berechtigungsrolle','like','%'.$this->searchQuery.'%')
                ->get()
                ->map(function ($rolle){
                    return $rolle->user;
                })->flatten();
        }
        else {
            $users = User::search($this->searchQuery);
        }
        return view('livewire.search-users-component',[
            'users' => $users->paginate(10),
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }

    private function hasSpecialChars($string){
        return preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $string);//[@_!#$%^&*()<>?/|}{~:]
    }
}

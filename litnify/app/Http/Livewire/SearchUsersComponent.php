<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SearchUsersComponent extends Component
{
    use WithPagination, WithSorting;

    protected $paginationTheme = 'bootstrap';
    public $searchQuery;
    public $nutzerverwaltung=false;
    public $deleted=0;

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sortDirection='asc';
        $this->sortBy('nachname');
    }

    public function render()
    {
        $users=Suche::getInstance()->searchUsers($this->searchQuery);

        /*Deaktivierte Nutzer in Direktverleih ausblenden*/
        if ($this->nutzerverwaltung==false){
            $users=$users->where('deleted',0);
        }else{
            $users=$users->where('deleted',$this->deleted);
        }

        $users= $this->sortDirection=='asc' ? $users->sortByDesc($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE) : $users->sortBy($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE);
        return view('livewire.search-users-component',[
            'users' => $users->paginate(10),
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'exportData' => $users->toArray(),
        ]);
    }
}

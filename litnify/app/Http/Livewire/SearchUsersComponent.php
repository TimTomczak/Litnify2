<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use Livewire\Component;
use Livewire\WithPagination;

class SearchUsersComponent extends Component
{
    use WithPagination, WithSorting;

    protected $paginationTheme = 'bootstrap';
    public $searchQuery;

    public function render()
    {
        $users=Suche::getInstance()->searchUsers($this->searchQuery);
        $users= $this->sortDirection=='asc' ? $users->sortByDesc($this->sortBy) : $users->sortBy($this->sortBy);
        return view('livewire.search-users-component',[
            'users' => $users->paginate(10),
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }
}

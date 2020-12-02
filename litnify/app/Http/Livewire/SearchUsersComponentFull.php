<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use Livewire\Component;
use Livewire\WithPagination;

class SearchUsersComponentFull extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $searchQuery;

    public function render()
    {
        return view('livewire.search-users-component-full',[
            'users' => Suche::getInstance()->searchUsers($this->searchQuery)->paginate(10),
            'tableBuilder' => TableBuilder::$nutzerverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }
}

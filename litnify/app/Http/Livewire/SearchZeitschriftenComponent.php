<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use Livewire\Component;
use Livewire\WithPagination;

class SearchZeitschriftenComponent extends Component
{
    use WithPagination, WithSorting;

    protected $paginationTheme = 'bootstrap';

    public $searchQuery;

    public function render()
    {
        $zeitschriften=Suche::getInstance()->searchZeitschriften($this->searchQuery)->get();
        $zeitschriften= $this->sortDirection=='asc' ? $zeitschriften->sortByDesc($this->sortBy) : $zeitschriften->sortBy($this->sortBy);

        return view('livewire.search-zeitschriften-component',[
            'zeitschriften' => $zeitschriften->paginate(10),
            'tableStyle' => TableBuilder::$tableStyle,
            'tableBuilder' => TableBuilder::$zeitschrifenverwaltungIndex,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }
}

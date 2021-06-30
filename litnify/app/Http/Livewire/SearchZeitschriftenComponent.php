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

    public $deleted=0;
    public $searchQuery;

    public function mount()
    {
        $this->sortDirection='asc';
        $this->sortBy('id');
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function render()
    {
        $zeitschriften=Suche::getInstance()->searchZeitschriften($this->searchQuery)->get()->where('deleted',$this->deleted);
        $zeitschriften= $this->sortDirection=='asc' ? $zeitschriften->sortByDesc($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE) : $zeitschriften->sortBy($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE);

        return view('livewire.search-zeitschriften-component',[
            'zeitschriften' => $zeitschriften->paginate(10),
            'tableStyle' => TableBuilder::$tableStyle,
            'tableBuilder' => TableBuilder::$zeitschrifenverwaltungIndex,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'exportData' => $zeitschriften->toArray(),
        ]);
    }
}

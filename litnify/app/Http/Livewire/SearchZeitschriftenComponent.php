<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use Livewire\Component;
use Livewire\WithPagination;

class SearchZeitschriftenComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchQuery;

    public function render()
    {
        return view('livewire.search-zeitschriften-component',[
            'zeitschriften' => Suche::getInstance()->searchZeitschriften($this->searchQuery)->paginate(10),
            'tableStyle' => TableBuilder::$tableStyle,
            'tableBuilder' => TableBuilder::$zeitschrifenverwaltungIndex,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }
}

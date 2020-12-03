<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use App\Models\Medium;
use Livewire\Component;
use Livewire\WithPagination;

class SearchMedienComponent extends Component
{
    use WithPagination, WithSorting;
    protected $paginationTheme = 'bootstrap';


    public $searchQuery;

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sortDirection='desc';
        $this->sortBy('id');
    }

    public function render()
    {
        if ($this->searchQuery==null){
            $medien = Medium::orderBy('id','DESC')->where('deleted',0)->where('released',1);
        }else{
            $medien=Suche::getInstance()->searchMedien($this->searchQuery)->get();
            $medien= $this->sortDirection=='asc' ? $medien->sortByDesc($this->sortBy) : $medien->sortBy($this->sortBy);
        }
        return view('livewire.search-medien-component',[
            'medien' => $medien->paginate(10),
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
        ]);
    }
}

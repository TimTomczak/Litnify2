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

    public $deleted=0;
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
            $medien = $this->sortDirection=='asc' ?
                Medium::orderBy($this->sortBy,'DESC')->where('deleted',$this->deleted)->where('released',1) :
                Medium::orderBy($this->sortBy,'ASC')->where('deleted',$this->deleted)->where('released',1);
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

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
                Medium::with('literaturart')->orderBy($this->sortBy,'DESC')->where('deleted',$this->deleted)->where('released',1) :
                Medium::with('literaturart')->orderBy($this->sortBy,'ASC')->where('deleted',$this->deleted)->where('released',1);
        }else{
            $medien=Suche::getInstance()->searchMedien($this->searchQuery)->get()->where('deleted',$this->deleted)->load('literaturart');
            $medien= $this->sortDirection=='asc' ? $medien->sortByDesc($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE) : $medien->sortBy($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE);
        }
        $this->emit('rerenderPanel',$medien->paginate(10)->items());
        return view('livewire.search-medien-component',[
            'medien' => $medien->paginate(10),
            'tableBuilder' => TableBuilder::$medienverwaltungIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'exportData' => $medien->paginate(10)->items(),
        ]);
    }
}

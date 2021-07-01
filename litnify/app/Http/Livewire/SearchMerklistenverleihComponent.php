<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Merkliste;
use Livewire\Component;
use Livewire\WithPagination;

class SearchMerklistenverleihComponent extends Component
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
        $this->sortDirection='asc';
        $this->sortBy('name');
    }

    public function render()
    {
        $merkliste = (new Merkliste());
        if ($this->searchQuery==null){
            $merk = $this->sortDirection=='asc' ?

                $merkliste->getNutzerMerklisten()->sortBy($this->sortBy,SORT_NATURAL|SORT_FLAG_CASE, true) :
                $merkliste->getNutzerMerklisten()->sortBy($this->sortBy,SORT_NATURAL|SORT_FLAG_CASE, false);
        }else{
            $merk = $merkliste->getNutzerMerklisten();

            $searching_for =$this->searchQuery;
            $merk=$merk->filter(function($merkliste) use ($searching_for){
                return stristr($merkliste->user_id, $searching_for) ||
                    stristr($merkliste->email, $searching_for) ||
                    stristr($merkliste->name, $searching_for) ||
                    stristr($merkliste->anzahl_medien_auf_merkliste, $searching_for) ||
                    stristr($merkliste->davon_ausleihbar, $searching_for);
            });
            $merk= $this->sortDirection=='asc' ? $merk->sortByDesc($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE) : $merk->sortBy($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE);
        }

        return view('livewire.search-merklistenverleih-component',[
            'merklisten' => $merk->paginate(10),
            'tableStyle' => TableBuilder::$tableStyle,
            'tableBuilder' => TableBuilder::$merklistenverleihIndex,
        ]);
    }
}

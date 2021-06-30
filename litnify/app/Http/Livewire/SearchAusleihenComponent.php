<?php

namespace App\Http\Livewire;

use App\Helpers\Suche;
use App\Helpers\TableBuilder;
use App\Models\Ausleihe;
use Livewire\Component;
use Livewire\WithPagination;

class SearchAusleihenComponent extends Component
{
    use WithPagination, WithSorting;
    protected $paginationTheme = 'bootstrap';
    public $showAktiv;
    public $searchQuery;
    public $deleted=0;

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
        $ausleihen=Suche::getInstance()->searchAusleihen($this->searchQuery)->get();

        if ($this->showAktiv){
            $ausleihen=$ausleihen->whereNull('RueckgabeIst');
        }
        else{
            $ausleihen=$ausleihen->whereNotNull('RueckgabeIst');
        }

        if ($this->deleted==1){
            $ausleihen=$ausleihen->where('deleted',1);
        }else{
            $ausleihen=$ausleihen->where('deleted',0);
        }

        /* Ausleihen den Namen des Nutzers hinzufügen */
        $ausleihen=$ausleihen->map(function ($aus){
            $ausleihe=$aus->toArray(); //in Array umwandeln
            $ausleihe+=['name'=>$ausleihe['user']['nachname'].', '.$ausleihe['user']['vorname']]; //Name aus "user" herausholen und zusammenfügen, als "name" ins Array einfügen
            unset($ausleihe['user']); // "user aus Array entfernen"
            return Ausleihe::hydrate([$ausleihe])->first(); // neues Model mit Array (jetzt mit Nutzernamen hydrieren)
        });

        $ausleihen= $this->sortDirection=='asc' ? $ausleihen->sortByDesc($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE) : $ausleihen->sortBy($this->sortBy, SORT_NATURAL|SORT_FLAG_CASE);
        return view('livewire.search-ausleihen-component',[
            'ausleihen' => $this->dbTimestampToGermanDate($ausleihen)->paginate(10),
            'tableBuilder' => TableBuilder::$ausleihverwaltungIndex_AktiveAusleihen,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28),
            'exportData' => $this->dbTimestampToGermanDate($ausleihen)->paginate(10)->items(),
        ]);
    }

    private function dbTimestampToGermanDate($ausleihen)
    {
        foreach ($ausleihen as $ausleihe) {
            $ausleihe->RueckgabeSoll = $ausleihe->RueckgabeSoll != null ? date("d.m.Y", strtotime($ausleihe->RueckgabeSoll)) : $ausleihe->RueckgabeSoll;
            $ausleihe->Ausleihdatum = $ausleihe->Ausleihdatum != null  ? date("d.m.Y", strtotime($ausleihe->Ausleihdatum)) : $ausleihe->Ausleihdatum;
            $ausleihe->RueckgabeIst = $ausleihe->RueckgabeIst != null ? date("d.m.Y", strtotime($ausleihe->RueckgabeIst)) : $ausleihe->RueckgabeIst;
        }
        return $ausleihen;
    }

}

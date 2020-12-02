<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Medium;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SearchMedienAusleihbarComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $user;
    public $suche;

    public function render()
    {


        if ($this->suche!=null){
            $medien=$this->searchMedienAusleihbar($this->suche);
        }else{
            $medien=DB::table('medien_ausleihbar')
                ->select('medien_ausleihbar.medium_id','medien_ausleihbar.hauptsachtitel','medien_ausleihbar.autoren','medien_ausleihbar.jahr','medien_ausleihbar.signatur')
                ->distinct()
                ->get();
        }

        return view('livewire.search-medien-ausleihbar-component',[
            'tableBuilder' => TableBuilder::$direktverleihIndex,
            'tableStyle' => TableBuilder::$tableStyle,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'user' => $this->user,
            'medien' => Medium::whereIn('id',$medien->pluck('medium_id'))->paginate(10),
            'ausleihdauerDefault' => (int)env('AUSLEIHDAUER',28)
        ]);
    }

    private function searchMedienAusleihbar($searchString){
        $result=DB::table('medien_ausleihbar')
//            ->join('literaturarten','medien_ausleihbar.literaturart_id','=','literaturarten.id')
            ->select('medien_ausleihbar.medium_id','medien_ausleihbar.hauptsachtitel','medien_ausleihbar.autoren','medien_ausleihbar.jahr','medien_ausleihbar.signatur')
            ->distinct()
            ->where('hauptsachtitel','like','%'.$searchString.'%')
            ->orWhere('autoren','like','%'.$searchString.'%')
            ->orWhere('jahr','like','%'.$searchString.'%')
            ->orWhere('signatur','like','%'.$searchString.'%')
//            ->orWhere('literaturart','like','%'.$searchString.'%')
            ->get();
//        dd($result);
//        $result=Medium::with('literaturart')->hydrate($result->toArray());
        return $result;
    }

}

<?php

namespace App\Http\Livewire;

use App\Helpers\TableBuilder;
use App\Models\Medium;
use Livewire\Component;
use function GuzzleHttp\Psr7\str;

class BestandNachSystematikgruppenComponent extends Component
{
    public $i=0;//Anzahl an Namen
    public $inputs=[];
    public $sysgrp_inputs;
    public $systematikgruppen;
    protected $result;
    public $literaturart;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $sysgrp=Medium::distinct('signatur')->orderBy('signatur')->pluck('signatur');

        //Alle Systematikgruppen aus Signaturen
        $sysgrp=$sysgrp->filter(function ($item){
            if (preg_match('/([A-Z]{3})/',$item)){
                return $item;
            }
        });
        $this->systematikgruppen=$sysgrp;

        // Systematiken (Obergruppen)
        $systematiken_obergruppen=$sysgrp->filter(function ($item){
            if (strpos($item,'-')==false){
                return $item;
            }
        });
//        dd($systematiken_obergruppen);

        $systematiken_obergruppen=$systematiken_obergruppen->map(function ($item){
            return $item=substr($item,0,4);
        })->unique();

        $systematiken_obergruppen=$systematiken_obergruppen->filter(function ($item){
            if (strpos($item,' ')==false){
                return $item;
            }
        });
//        dd($systematiken_obergruppen);
//        dd($systematiken_obergruppen);
        $this->systematikgruppen=$systematiken_obergruppen;

        $this->result=collect();
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        unset($this->sysgrp_inputs[$i]);
    }

    public function render()
    {
//        dd($this->sysgrp_inputs);
        $this->searchMediumBySystematikgruppen();
//        dd($this->result);
        $this->emit('rerenderPanel',$this->result);
//        dd($this->result);
//        dd($this->result->where('id',137214)->toArray());
        if ($this->literaturart=="2"){
            $exportData=$this->result->map(function($med){
                $mediumInventarnummernAsArray=$med->inventarliste->pluck('inventarnummer')->toArray();
                $med->inventarnummer = implode(', ',$mediumInventarnummernAsArray);
                return $med;
            });
            $tableBuilder=TableBuilder::$bestandNachSystematikgruppenBuch;
        }
        else{
            $exportData = $this->result;
            $tableBuilder=TableBuilder::$bestandNachSystematikgruppenGraulit;
        }



        return view('livewire.bestand-nach-systematikgruppen-component',[
            'systematikgruppen'=>$this->systematikgruppen,
            'aktionenStyles' => TableBuilder::$aktionenStyles,
            'result' => $this->result,
            'exportData' => $exportData->toArray(),
            'tableBuilder' => $tableBuilder,
        ]);
    }

    private function searchMediumBySystematikgruppen(){
        $this->result=collect();
        $result=collect();
        if (empty($this->sysgrp_inputs)==false){
            foreach ($this->sysgrp_inputs as $sysgrp){
                $res=Medium::with('inventarliste:inventarnummer')->where('literaturart_id',$this->literaturart)->where('signatur','like','%'.$sysgrp.'%')->get();
                foreach ($res as $item){
                    $result->add($item);
                }
//                dd($result);
            }
        }
//        dd($result);
        $this->result=$result->sortBy('signatur');
    }


}

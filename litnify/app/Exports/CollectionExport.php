<?php

namespace App\Exports;

use App\Models\Berechtigungsrolle;
use App\Models\Literaturart;
use App\Models\Raum;
use App\Models\Zeitschrift;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollectionExport implements FromCollection,WithHeadings,ShouldQueue
{
    use Exportable;

    private $exportData;    // Zu exportierende Daten als Collection
    private $columns;   // Spalten, die der Export haben soll

    public function __construct($exportData,$columns)
    {
        $this->exportData=$exportData;
        $this->columns=$columns;
    }

    /**
     * Gibt die endgültig zu exportierende Collection zurück
    */
    public function collection()
    {
        $exportData=array_map(function($item){ //mappt das Daten-Array so, dass nur die entsprechenden Spalten aus coloums übrig bleiben
            return array_intersect_key($item,$this->columns);
        },$this->exportData);
        $exportData=$this->mapForeignKeys($exportData);
        return collect($exportData); // ->map->only([]) mappt die Collection, sodass nur die zu exportierenden Spalten übrig bleiben
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->columns;
    }

    /**
     * Tauscht die Fremdschlüsselwerte der Models in der Collection gegen die entsprechenden Strings aus
     * Bspw.: Medium hat literaturart_id = 1, daraus wird literaturart_id = "Artikel"
     *
     * @param array $exportData
     * @return array
     */
    private function mapForeignKeys(array $exportData){
        if (isset($exportData[0]['literaturart_id'])){                  // Wenn literaturart_id in Collection ...
            $literaturarten=Literaturart::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['literaturart_id']=$literaturarten[$data['literaturart_id']-1]['literaturart'];
            }
        }

        if (isset($exportData[0]['raum_id'])){                          // Wenn raum_id in Collection ...
            $literaturarten=Raum::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['raum_id']=$literaturarten[$data['raum_id']-1]['raum'];
            }

//            $exportData=array_map(function($item){
//                $item['raum_id']=Raum::whereId($item['raum_id'])->firstOrFail()->raum;
//                return $item;
//            },$exportData);
        }

        if (isset($exportData[0]['zeitschrift_id'])){                  // Wenn literaturart_id in Collection ...
            $literaturarten=Zeitschrift::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['zeitschrift_id']=$literaturarten[$data['zeitschrift_id']-1]['name'];
            }
//            $exportData=array_map(function($item){
//                $item['zeitschrift_id']=Zeitschrift::whereId($item['zeitschrift_id'])->firstOrFail()->name;
//                return $item;
//            },$exportData);
        }

        if (isset($exportData[0]['berechtigungsrolle_id'])){                  // Wenn literaturart_id in Collection ...
            $literaturarten=Berechtigungsrolle::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['berechtigungsrolle_id']=$literaturarten[$data['berechtigungsrolle_id']-1]['berechtigungsrolle'];
            }

//            $exportData=array_map(function($item){
//                $item['berechtigungsrolle_id']=Berechtigungsrolle::whereId($item['berechtigungsrolle_id'])->firstOrFail()->berechtigungsrolle;
//                return $item;
//            },$exportData);
        }

        /* Array nach Spalten ordnen */
        $exportData=array_map(function($item){
            $arr_ordered=[];
            foreach ($this->columns as $key=>$val){
                $arr_ordered[$key]=$item[$key];
            }
            return $arr_ordered;
        },$exportData);

        return $exportData;
    }
}

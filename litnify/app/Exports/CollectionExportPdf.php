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
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;

class CollectionExportPdf implements FromCollection,WithHeadings,ShouldQueue,ShouldAutoSize, WithEvents
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
        if (isset($exportData[array_key_first($exportData)]['literaturart_id'])){                  // Wenn literaturart_id in Collection ...
            $literaturarten=Literaturart::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['literaturart_id']=$literaturarten[$data['literaturart_id']-1]['literaturart'];
            }
        }

        if (isset($exportData[0]['raum_id'])){                          // Wenn raum_id in Collection ...
            $raeume=Raum::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['raum_id']=$raeume[$data['raum_id']-1]['raum'];
            }
        }

        if (isset($exportData[0]['zeitschrift_id'])){                  // Wenn literaturart_id in Collection ...
            $zeitschriften=Zeitschrift::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['zeitschrift_id']=$zeitschriften[$data['zeitschrift_id']-1]['name'];
            }
        }

        if (isset($exportData[0]['berechtigungsrolle_id'])){                  // Wenn literaturart_id in Collection ...
            $berechtigungsrollen=Berechtigungsrolle::all()->toArray();
            foreach ($exportData as $key=>$data){
                $exportData[$key]['berechtigungsrolle_id']=$berechtigungsrollen[$data['berechtigungsrolle_id']]['berechtigungsrolle'];
            }
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

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function(BeforeWriting $event){
                $event->writer->getDelegate()->getCellXfCollection()[0]->getAlignment()->setTextRotation(90);
                $event->writer->getDelegate()->getCellXfCollection()[0]->getBorders()->getLeft()->setBorderStyle(true);
                $event->writer->getDelegate()->getCellXfCollection()[0]->getBorders()->getRight()->setBorderStyle(true);
                $event->writer->getDelegate()->getCellXfCollection()[0]->getBorders()->getTop()->setBorderStyle(true);
                $event->writer->getDelegate()->getCellXfCollection()[0]->getBorders()->getBottom()->setBorderStyle(true);
            }
        ];
    }
}

<?php

namespace App\Exports;

use App\Helpers\CollectionExportHelper;
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
//        dd($exportData);

        $exportData=CollectionExportHelper::mapForeignKeys($exportData,$this->columns);

        return collect($exportData); // ->map->only([]) mappt die Collection, sodass nur die zu exportierenden Spalten übrig bleiben
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->columns;
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

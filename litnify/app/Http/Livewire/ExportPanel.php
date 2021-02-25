<?php

namespace App\Http\Livewire;

use App\Exports\CollectionExport;
use App\Helpers\BibtexHelper;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportPanel extends Component
{
    public $exportData;     // die zu exportierenden Daten als Array (Collection->toArray())
    public $downloadName;   // der Name der zu downloadenden Datei
    public $cols;           // die Spalten, die die zu downloadende Datei enthalten soll als Array: key = key der Daten, value = Name der Tabellenspalte
    public $withBib=false;    // die zur option stehenden Export-Typen: bspw. 'xls','pdf' ...

    protected $listeners = ['rerenderPanel' => 'rerenderData'];

    public function render()
    {
        return view('livewire.export-panel');
    }

    public function exportPdf(){
        return (new CollectionExport($this->exportData, $this->cols))
            ->download(
                $this->downloadName.'.pdf',
                \Maatwebsite\Excel\Excel::DOMPDF
            );
    }

    public function exportXls(){
        return (new CollectionExport($this->exportData, $this->cols))
            ->download(
                $this->downloadName.'.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );
    }

    public function exportCsv(){
        return (new CollectionExport($this->exportData, $this->cols))
            ->download(
                $this->downloadName.'.csv',
                \Maatwebsite\Excel\Excel::CSV
            );
    }

    public function exportBib(){
//        dd("Not working yet ...");
//        dd($this->exportData);

        return response()->streamDownload(function(){
            echo (new BibtexHelper($this->exportData))->getBibtex();;
        },$this->downloadName.'.bib');
    }

    public function rerenderData($newData){
        $this->exportData=$newData;
    }

}

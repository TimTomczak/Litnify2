<?php

namespace App\Models;

use App\Exports\MerklisteExport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\EnumeratesValues;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;

class Download extends Model
{
    use EnumeratesValues;

    public $list;
    public $extension;

    // Define possible exports
    protected $enumExtensions = [
        'pdf',
        'xls',
        'csv',
        'bib'
    ];

    // Define possible lists to export
    protected $enumLists = [
        'merkliste',
        //'ausleihen'
    ];

    private function verifyInput(){
        $extensions = collect($this->enumExtensions);
        $lists = collect($this->enumLists);

        if (!($extensions->some($this->extension) && $lists->some($this->list))){
            // @todo: Redirect mit Fehlermeldung: Liste oder Extension falsch
            // return redirect(route('admin.nutzerverwaltung'))->with([
            //                'title' => 'Nutzerverwaltung',
            //                'message' => 'Angemeldeter Account kann nicht verändert werden.',
            //                'alertType'=> 'danger'
            //            ]);

            return false;
        }
    }

    private function getData(){
        if($this->extension != 'bib'){
            $class = 'App\Exports\\' . ucfirst($this->list) . 'Export';
            return (new $class());
        }
        else{
            //@todo: Bibtex Export
            return 'Bibtext Export';
        }
    }

    private function addWriter(){
        // \Maatwebsite\Excel\Excel::DOMPDF
        return null;
    }

    public function download(){
        $this->verifyInput();
        $object = $this->getData();
        if($this->extension != 'bib'){
            $writer = $this->addWriter();
            return Excel::download($object, $this->list . '.' . $this->extension, $writer);
        }
        else{
            $filename = $this->list . '.bib';
                return response()->streamDownload(function () use ($object) {
                    echo $object;
                }, $filename);
        }

    }

}

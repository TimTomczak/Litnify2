<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use App\Helpers\TableBuilder;
use Carbon\Carbon;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class ActionLogComponent extends Component
{
    public $date;

    public function render()
    {
        if ($this->date==null){
            if (!empty($this->getLogDates())){
                $this->date=$this->getLogDates()[0]; //falls noch kein Daum ausgewählt, erstes vorhandenes Datum initital auswählen
            }
        }
        $logdates=$this->getLogDates();
        rsort($logdates); //Daten in absteigender Reihenfolge sortieren

        $this->date=empty($logdates) ?
            '' :
            $this->date=$logdates[0]; //erstes Datum (Neustes) "auswählen";



        return view('livewire.action-log-component',[
            'log_dates' =>  $logdates,
            'data' => $this->filterActions($this->parseActionLogs($this->date)),
            'log_aktionen' => TableBuilder::$logAktionen,
        ]);
    }

    private function getLogDates(){
        $log_dates=[];
        $files = File::allFiles(storage_path('logs/aktionen'));
        foreach ($files as $file){
            $filename=$file->getFilename();
            $filename=str_replace('aktionen-','',$filename);
            $filename=str_replace('.log','',$filename);
            array_push($log_dates,date('d.m.Y',strtotime($filename)));
        }
        return $log_dates;
    }

    private function parseActionLogs($date){
        $date = Carbon::create($date);
        try {
            $logfile = File::get(storage_path('logs/aktionen/aktionen-' . $date->format('Y-m-d') . '.log'));
        } catch (FileNotFoundException $e) {
//            return abort(403, 'Zu diesem Datum sind keine Logs verfügbar.');
            return [];
        }
        return Helper::parseActionLog($logfile);
    }

    private function filterActions($actions){
        $filtered=[];
        foreach ($actions as $item){
            if (array_key_exists($item['aktion'],TableBuilder::$logAktionen)){
                array_push($filtered,$item);
            }
        }
        return $filtered;
    }


}

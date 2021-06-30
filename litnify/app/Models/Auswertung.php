<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;

class Auswertung extends Model
{

    public static $auswertungenTabs=[
        'Top Ausleihen',
        'Ueberfaellige Ausleihen',
        'Bestand nach Systematikgruppen',
        'Bestand nach Erscheinungsjahr'
    ];

    /**
     * Gibt die Anzahl der Ausleihen eines Mediums und die jeweilige Medium-ID zurück
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getTopAusleihen()
    {
        return DB::table('ausleihen')
            ->join('medien','medien.id', '=','ausleihen.medium_id')
            ->groupBy('medium_id')
            ->select('medien.*',DB::raw("COUNT(*) as anzahl"))
            ->orderByDesc('anzahl')
            ->get();
    }

    public static function getAusleihenUeberfaellig()
    {
        return Ausleihe::with('user:id,vorname,nachname')->whereNull('RueckgabeIst')
            ->where('RueckgabeSoll','<',date('Y-m-d',time()))
            ->where('deleted',0)
            ->get()
            ->map(function ($aus){
                $ausleihe=$aus->toArray();
                $ausleihe+=['name'=>$ausleihe['user']['nachname'].', '.$ausleihe['user']['vorname']];
                unset($ausleihe['user']);
                return Ausleihe::hydrate([$ausleihe])->first();
            });
    }
}

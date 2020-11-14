<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    protected $fillable = [
        'id',
        'literaturart_id' ,
        'signatur' ,
        'autoren' ,
        'hauptsachtitel' ,
        'untertitel' ,
        'enthalten_in' ,
        'erscheinungsort' ,
        'jahr' ,
        'verlag' ,
        'isbn' ,
        'issn' ,
        'doi' ,
//            'inventarnummer' ,
        'auflage' ,
        'herausgeber' ,
        'schriftenreihe' ,
        'zeitschrift_id' ,
        'band' ,
        'seite' ,
        'institut' ,
        'raum_id' ,
        'bemerkungen' ,
        'deleted',
        'released'
    ];

    protected $table='medien';

    public function merkliste(){
        return $this->belongsToMany(User::class, 'merkliste')
            ->withPivot('created_at');
    }

    public function ausleihe(){
        return $this->belongsToMany(User::class, 'ausleihen')
            ->withPivot(['id','inventarnummer','Ausleihdatum','RueckgabeSoll','RueckgabeIst','Verlaengerungen']);
    }

    public function raum(){
        return $this->belongsTo(Raum::class);
    }

    public function zeitschrift(){
        return $this->belongsTo(Zeitschrift::class, );
    }

    public function literaturart(){
        return $this->belongsTo(Literaturart::class);
    }

    public function inventarliste(){
        return $this->belongsToMany(Inventarliste::class, 'inventarliste_medium');
    }

    public function isAusleihbar(){
        $medienAufInventarliste=$this->inventarliste->all();
        foreach ($medienAufInventarliste as $medOnInv){ //alle Inventarnummern des Mediums überprüfen
            if ($medOnInv->ausleihbar==1){ //ist das Medium ausleihbar ?
                // dann prüfe, ob die Inventarnummer bereits ausgeliehen ist
                $invAusgeliehen=Ausleihe::whereInventarnummer($medOnInv->inventarnummer)->where('medium_id',$medOnInv->medium_id)->get();
                if ($invAusgeliehen->isEmpty()){
                    //Wenn nicht in Ausleihen ist mindestens eine Inventarnummer ausleihbar
                    return true;
                }
                else{
                    //Wenn in Ausleihen vorhanden: Prüfen, ob die Inventarnummern zurückgegeben wurden (RueckgabeIst)
                    if($invAusgeliehen->pluck('RueckgabeIst')->contains(null)){
                        continue; // Inventarnummer noch nicht zurückgegeben -> Nächste überprüfen
                    }else{
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getInventarnummernAusleihbar(){
        $inventarnummernAusleihbar = collect();
        $inventarliste = $this->inventarliste->where('ausleihbar',1)->all();
        foreach ($inventarliste as $mediumAufInventarliste){
            $mediumAusgeliehen = Ausleihe::whereMediumId($mediumAufInventarliste->medium_id)
                ->where('inventarnummer',$mediumAufInventarliste->inventarnummer)
                ->where('RueckgabeIst',null)->get();
            if ($mediumAusgeliehen->isEmpty()){
                $inventarnummernAusleihbar->push($mediumAufInventarliste->inventarnummer);
            }
            else{
                continue;
            }
        }
        return $inventarnummernAusleihbar;
    }
}

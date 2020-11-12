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

    public function user(){
        return $this->belongsToMany(User::class, 'merkliste');
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
                $invAusgeliehen=Ausleihe::whereInventarnummer($medOnInv->inventarnummer);
                if ($invAusgeliehen==null){ // TODO == null oder empty oder so ?
                    //Wenn nicht in Ausleihen -> ausleihbar
                    return true;
                }
                else{
                    //prüfen, ob Inventarnummer in Ausleihen noch nicht zurückgegeben wurde
                    // TODO alle iterieren und auf RueckgabeIst==null prüfen
                }


            }

        }
    }
}

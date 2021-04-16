<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Medium extends Model
{
    use Searchable;

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

//    protected $with=['literaturart','raum','zeitschrift'];



    public function toSearchableArray()
    {

        $array= [
//        'id' => $this->id,
        'signatur' => $this->signatur ,
        'autoren' =>$this->autoren,
        'hauptsachtitel' =>$this->hauptsachtitel,
        'untertitel' =>$this->untertitel,
        'enthalten_in' =>$this->enthalten_in,
        'erscheinungsort' =>$this->erscheinungsort,
//        'literaturart' => $this->literaturart->literaturart,
        'jahr' => $this->jahr ,
        'verlag' =>$this->verlag,
        'isbn' => $this->isbn,
        'issn' => $this->signatur,
        'doi' => $this->signatur,
        'auflage' => $this->auflage ,
        'herausgeber' => $this->herausgeber ,
        'schriftenreihe' => $this->schriftenreihe,
        'band' => $this->band,
//        'seite' => $this->seite,
        'institut' => $this->institut,
//        'bemerkungen' => $this->bemerkungen,
    ];
//        $array = $this->transform($array);
//        $array['literaturart'] = $this->literaturart->literaturart;
//        $array['inventarnummer'] = $this->inventarliste->inventarnummer;
//        $array['raum'] = $this->raum->raum;
//        $array['zeitschrift'] = $this->zeitschrift->name;

        // Applies Scout Extended default transformations:

        // Add an extra attribute:

        return $array;
    }

    public function merkliste(){
        return $this->belongsToMany(User::class, 'merkliste')
            ->withPivot('id','created_at');
    }

    public function ausleihe(){
        return $this->belongsToMany(User::class, 'ausleihen')
            ->withPivot(['id','inventarnummer','Ausleihdatum','RueckgabeSoll','RueckgabeIst','Verlaengerungen']);
    }

    public function raum(){
        return $this->belongsTo(Raum::class);
    }

    public function zeitschrift(){
        return $this->belongsTo(Zeitschrift::class);
    }

    public function literaturart(){
        return $this->belongsTo(Literaturart::class);
    }

    public function inventarliste(){
        return $this->belongsToMany(Inventarliste::class, 'inventarliste_medium')->withTimestamps();
    }

    public function isAusleihbar(){
//        $medienAufInventarliste=$this->inventarliste->all();
//        foreach ($medienAufInventarliste as $medOnInv){ //alle Inventarnummern des Mediums überprüfen
//            if ($medOnInv->ausleihbar==1){ //ist das Medium ausleihbar ?
//                // dann prüfe, ob die Inventarnummer bereits ausgeliehen ist
//                $invAusgeliehen=Ausleihe::whereInventarnummer($medOnInv->inventarnummer)->where('medium_id',$medOnInv->medium_id)->get();
//                if ($invAusgeliehen->isEmpty()){
//                    //Wenn nicht in Ausleihen ist mindestens eine Inventarnummer ausleihbar
//                    return true;
//                }
//                else{
//                    //Wenn in Ausleihen vorhanden: Prüfen, ob die Inventarnummern zurückgegeben wurden (RueckgabeIst)
//                    if($invAusgeliehen->pluck('RueckgabeIst')->contains(null)){
//                        continue; // Inventarnummer noch nicht zurückgegeben -> Nächste überprüfen
//                    }else{
//                        return true;
//                    }
//                }
//            }
//        }
//        return false;
        return $this->getInventarnummernAusleihbar()->isEmpty()==false;
    }

    public function getInventarnummernAusleihbar(){
//        $inventarnummernAusleihbar = collect();
//        $inventarnummernNichtZurueck = DB::table('ausleihen_offen')->where('medium_id',[$this->id])->pluck('inventarnummer');
////        dd($this->with('inventarliste')->whereId($this->id)->get()->first()->inventarliste);
//        $inventarnummernAusleiheMoeglich = $this->inventarliste->where('ausleihbar',1)->pluck('inventarnummer');
//        foreach ($inventarnummernAusleiheMoeglich as $invMgl){
//            if ($inventarnummernNichtZurueck->contains($invMgl)){
//                continue;
//            }
//            else{
//                $inventarnummernAusleihbar->push($invMgl);
//            }
//        }
//        return $inventarnummernAusleihbar;

        return $inventarnummernAusleihbar=DB::table('medien_ausleihbar')->where('medium_id',[$this->id])->pluck('inventarnummer');

    }
}

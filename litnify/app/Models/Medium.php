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
        'deleted'
    ];

    protected $table='medien';

    public function user(){
        return $this->belongsToMany(User::class, 'merkliste');
    }

    public function ausleihe(){
        return $this->belongsToMany(User::class, 'ausleihen');
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
}

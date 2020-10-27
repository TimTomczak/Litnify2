<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    protected $fillable = [
        'id',
        'signatur',
        'herausgeber',
        'jahr',
        'hauptsachtitel',
        'untertitel',
        'institut',
        'erscheinungsort',
        'schriftenreihe',
        'band',
        'bemerkungen',
        'seite',
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

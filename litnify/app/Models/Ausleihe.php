<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausleihe extends Model
{
    protected $table='ausleihen';

    protected $fillable=[
        'medium_id' ,
        'user_id' ,
        'inventarnummer',
        'Ausleihdatum' ,
        'Verlaengerungen',
        'RueckgabeSoll',
        'RueckgabeIst'
    ];

    public function medium(){
        return $this->belongsTo(Medium::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}

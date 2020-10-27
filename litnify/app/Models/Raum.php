<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raum extends Model
{
    protected $table='raeume';

    public function medium(){
        return $this->hasMany(Medium::class, 'raum');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zeitschrift extends Model
{
    protected $table='zeitschriften';

    public function medium(){
        return $this->hasMany(Medium::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarliste_Medium extends Model
{
    protected $table='inventarliste_medium';

    public function medium(){
        return $this->belongsTo(Medium::class);
    }

    public function inventarliste(){
        return $this->belongsTo(Inventarliste::class);
    }
}

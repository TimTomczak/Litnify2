<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Literaturart extends Model
{
    protected $table='literaturarten';

    public function medium(){
        return $this->hasMany(Medium::class, 'literaturart');
    }
}

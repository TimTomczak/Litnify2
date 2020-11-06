<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zeitschrift extends Model
{
    protected $table='zeitschriften';

    protected $fillable=[
        'id', 'name', 'shortcut', 'deleted'
    ];

    public function medium(){
        return $this->hasMany(Medium::class);
    }
}

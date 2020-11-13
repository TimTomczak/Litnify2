<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarliste extends Model
{
    protected $table='inventarliste';

    protected $fillable = [
        'medium_id',
        'inventarnummer',
        'isb',
        'ausleihbar',
        'deleted'
    ];

    public function medium(){
        return $this->belongsToMany(Medium::class, 'inventarliste_medium');
    }
}

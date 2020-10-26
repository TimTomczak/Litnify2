<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berechtigungsrolle extends Model
{
    public $table='berechtigungsrollen';

    public function user(){
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seiten extends Model
{
    protected $table='seiten';

    protected $fillable = [
        'title',
        'content'
    ];
}

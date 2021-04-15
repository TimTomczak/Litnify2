<?php

namespace App\Models;

use Carbon\Carbon;
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
        'RueckgabeIst',
        'deleted'
    ];

    public function medium(){
        return $this->belongsTo(Medium::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * @param $in_days
     * Legt fest in wie vielen Tagen, ab heute, die Rueckgabe fällig sein soll
     * @return \Illuminate\Support\Collection
     * Gibt eine Collection mit allen Ausleihen, die das RueckgabeSoll in $in_days Tagen haben
     */
    public function faelligInTagen($in_days){
        return $this->with(['user'])->whereNull('RueckgabeIst')
            ->where('RueckgabeSoll','like',Carbon::today()->addDays($in_days)->format('Y-m-d'))->get();
    }

}

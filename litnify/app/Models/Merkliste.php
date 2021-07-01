<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merkliste extends Model
{
    protected $table='merkliste';

    protected $fillable=['user_id', 'medium_id'];

    public function medium(){
        return $this->belongsTo(Medium::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getNutzerMerklisten(){
        $merklisten=$this->with('user', 'medium')->groupBy('user_id')->get();

        $merklisten = $merklisten->map(function ($merk){
            $merk=$merk->toArray();
            $merk+=[
                'email'=> $merk['user']['email']
            ];

            $merk+=[
                'name' => $merk['user']['nachname'].', '.$merk['user']['vorname']
            ];

            $merk+=[
                'anzahl_medien_auf_merkliste'=>\App\Models\Merkliste::where('user_id',$merk['user_id'])->count()
            ];

            $merk+=[
                'davon_ausleihbar'=>\App\Models\Merkliste::where('user_id',$merk['user_id'])->get()->filter(function($med){
                    if ($med->medium->isAusleihbar()){
                        return $med->medium;
                    }
                })->count()
            ];

            unset($merk['user']);
            unset($merk['medium']);
            unset($merk['medium_id']);
            unset($merk['created_at']);
            unset($merk['updated_at']);
            return Merkliste::hydrate([$merk])->first();
        });
        return $merklisten;
    }
}

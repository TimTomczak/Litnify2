<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nachname',
        'vorname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function medium(){
        return $this->belongsToMany(Medium::class, 'merkliste');
    }

    public function berechtigungsrolle(){
        return $this->belongsTo(Berechtigungsrolle::class, );
    }
    // Für Berechtigungsrolle des jeweiligen Users:  $user->berechtigungsrolle->berechtigungsrolle


    public function ausleihe(){
        return $this->belongsToMany(Medium::class, 'ausleihen');
    }
}

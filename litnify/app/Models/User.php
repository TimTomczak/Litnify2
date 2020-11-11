<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\HasLdapUser;


class User extends Authenticatable implements LdapAuthenticatable
{
    use HasFactory, Notifiable, AuthenticatesWithLdap, HasLdapUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nachname',
        'vorname',
        'email',
        'password'
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

    protected $attributes = [
        'berechtigungsrolle_id' => '1',

    ];

    public function medium(){
        return $this->belongsToMany(Medium::class, 'merkliste');
    }

    public function berechtigungsrolle(){
        return $this->belongsTo(Berechtigungsrolle::class );

    }
    // Für Berechtigungsrolle des jeweiligen Users:  $user->berechtigungsrolle->berechtigungsrolle


    public function ausleihe(){
        return $this->belongsToMany(Medium::class, 'ausleihen');
    }

    public function getLdapDomainColumn()
    {
        return 'domain';
    }

    public function getLdapGuidColumn()
    {
        return 'guid';
    }



    public function getLdapDomain()
    {
        // TODO: Implement getLdapDomain() method.
    }

    public function setLdapDomain($domain)
    {
        // TODO: Implement setLdapDomain() method.
    }



    public function getLdapGuid()
    {
        // TODO: Implement getLdapGuid() method.
    }

    public function setLdapGuid($guid)
    {
        // TODO: Implement setLdapGuid() method.
    }
}

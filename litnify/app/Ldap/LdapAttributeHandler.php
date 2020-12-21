<?php


namespace App\Ldap;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\OpenLDAP\User as LdapUser;

class LdapAttributeHandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database)
    {
        $nachname = $ldap->getFirstAttribute('sn');
        $vorname = str_replace($nachname, "", $ldap->getFirstAttribute('cn'));

        $database->vorname = $vorname;
        $database->nachname = $nachname;


        $database->email = $ldap->getFirstAttribute('mail');


    }
}

<?php

namespace App\Ldap\Rules;

use LdapRecord\Laravel\Auth\Rule;

class HasEmailProperty extends Rule
{
    /**
     * Check if the rule passes validation.
     *
     * @return bool
     */
    public function isValid()
    {
        return (!is_null($this->user->mail));
    }
}

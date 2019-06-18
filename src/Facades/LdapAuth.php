<?php namespace Joesama\Entree\Facades;

use Illuminate\Support\Facades\Facade;

class LdapAuth extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'ldap'; }

}
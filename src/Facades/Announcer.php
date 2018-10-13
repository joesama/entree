<?php

namespace Joesama\Entree\Facades;

use Illuminate\Support\Facades\Facade;

class Announcer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'announcer';
    }
}

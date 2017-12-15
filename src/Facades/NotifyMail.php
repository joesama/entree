<?php namespace Threef\Entree\Facades;

use Illuminate\Support\Facades\Facade;

class NotifyMail extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'emaillog'; }

}
<?php

namespace Joesama\Entree\Event\Listener;

use Illuminate\Auth\Events\Logout;
use Joesama\Entree\Database\Model\User;
use Joesama\Entree\Database\Model\UserTrails;

class EntreeUserLogout
{
    const LOGOUT = 0;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle User Login Event.
     *
     * @param joesama.user.login $event
     *
     * @return void
     */
    public function handle(Logout $person)
    {
        $trails = new UserTrails();

        $trails->type = self::LOGOUT;
        $trails->person = data_get($person, 'user.fullname');
        $trails->user_id = data_get($person, 'user.id');
        $trails->save();
    }
}

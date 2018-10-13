<?php

namespace Joesama\Entree\Event\Listener;

class EntreeRegisterUser
{
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
     * Handle User Insertion Event.
     *
     * @param joesama.user.profile $event
     *
     * @return void
     */
    public function handle($user, $input)
    {
        $email = array_get($input, 'emel');
        $user->username = strstr($email, '@', true);
    }
}

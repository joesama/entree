<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * Handle User Insertion Event
     *
     * @param  threef.user.profile  $event
     * @return void
     */
    public function handle($user, $input)
    {
        $email = array_get($input,'emel');
        $user->username = strstr($email, '@', true);

    }



}

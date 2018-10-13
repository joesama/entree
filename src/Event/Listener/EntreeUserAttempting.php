<?php

namespace Joesama\Entree\Event\Listener;

use Illuminate\Auth\Events\Lockout;
use Joesama\Entree\Database\Model\UserAttempting;

class EntreeUserAttempting
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
     * Handle User Login Event.
     *
     * @param joesama.user.login $event
     *
     * @return void
     */
    public function handle(Lockout $request)
    {
        $trails = new UserAttempting();
        $trails->username = $request->get('username');
        $trails->password = $request->get('password');
        $trails->ip_origin = ip_origin();
        $trails->save();
    }
}

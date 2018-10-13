<?php

namespace Joesama\Entree\Event\Listener;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Joesama\Entree\Database\Model\UserAccessTrails;

class EntreeSystemAccess implements ShouldQueue
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
    public function handle($uri, $method)
    {
        $ip = app('\Joesama\Entree\Entity\IpOrigin')->ipOrigin();

        $trails = new UserAccessTrails();
        $trails->user_id = data_get(\Auth::user(), 'id', null);
        $trails->ip = $ip;
        $trails->path = $uri;
        $trails->method = $method;
        $trails->save();
    }
}

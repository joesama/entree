<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Auth\Events\Login;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Threef\Entree\Database\Model\UserAccessTrails;

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
     * Handle User Login Event
     *
     * @param  threef.user.login  $event
     * @return void
     */
    public function handle($uri,$method)
    {
        $ip = app('\Threef\Entree\Entity\IpOrigin')->ipOrigin();

        $trails = new UserAccessTrails();
        $trails->user_id = data_get(\Auth::user(),'id',NULL);
        $trails->ip = $ip;
        $trails->path = $uri;
        $trails->method = $method;
        $trails->save();

    }



}

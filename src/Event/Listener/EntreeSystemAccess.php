<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Auth\Events\Login;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Threef\Entree\Database\Model\UserAccessTrails;

class EntreeSystemAccess
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
    public function handle($request)
    {
        $trails = new UserAccessTrails();
        $trails->user_id = \Auth::user()->id;
        $trails->path = $request->getUri();
        $trails->method = $request->getMethod();
        $trails->save();

    }



}

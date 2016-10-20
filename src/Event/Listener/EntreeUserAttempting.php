<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Auth\Events\Lockout;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Threef\Entree\Database\Model\UserAttempting;

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
     * Handle User Login Event
     *
     * @param  threef.user.login  $event
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

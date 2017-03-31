<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Auth\Events\Logout;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Threef\Entree\Database\Model\User;
use Threef\Entree\Database\Model\UserTrails;

class EntreeUserLogout
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
    public function handle(Logout $person)
    {
        $trails = new UserTrails();
        $trails->type = 0;
        $trails->person = data_get($person,'user.fullname');
        $trails->user_id = data_get($person,'user.id');
        $trails->save();

    }



}

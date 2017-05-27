<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Auth\Events\Login;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Threef\Entree\Database\Model\User;
use Threef\Entree\Database\Model\UserTrails;

class EntreeUserLogin
{
    const LOGIN = 1;

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
    public function handle($user)
    {
        $user->lastlogin = Carbon::now()->toDateTimeString();
        $user->save();

        $trails = new UserTrails();
        $trails->type = self::LOGIN;
        $trails->person = $user->fullname;
        $trails->user_id = $user->id;
        $trails->save();

    }



}

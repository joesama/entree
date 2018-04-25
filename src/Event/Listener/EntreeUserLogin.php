<?php

namespace Threef\Entree\Event\Listener;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
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
     * Handle User Login Event.
     *
     * @param threef.user.login $event
     *
     * @return void
     */
    public function handle($user)
    {
        $user->lastlogin = Carbon::now()->toDateTimeString();
        $user->save();

        $trails = new UserTrails();

        $trails->type = self::LOGIN;
        $trails->person = data_get($user, 'fullname');
        $trails->user_id = data_get($user, 'id');
        $trails->save();
    }
}

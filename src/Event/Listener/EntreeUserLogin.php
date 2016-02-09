<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Threef\Entree\Database\Model\User;
use Threef\Entree\Database\Model\UserTrails;

class EntreeUserLogin
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
    public function handle($user)
    {
        $user = User::find($user->id);
        $user->lastlogin = Carbon::now()->toDateTimeString();
        $user->save();

        $trails = new UserTrails();
        $trails->type = 1;
        $trails->user_id = $user->id;
        $trails->save();

    }



}

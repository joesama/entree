<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

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
     * Handle User Profile Creation Event
     *
     * @param  threef.user.profile  $event
     * @return void
     */
    public function handle($user)
    {
        // $user = User::find($user->id);
        $user->lastlogin = Carbon::now()->toDateTimeString();
        $user->save();

    }



}

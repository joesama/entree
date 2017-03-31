<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Auth\Events\Login;

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
    public function handle(Login $person)
    {
        $user = User::find($person->user->id);
        $user->lastlogin = Carbon::now()->toDateTimeString();
        $user->save();

        $trails = new UserTrails();
        $trails->type = 1;
        $trails->person = data_get($person,'user.fullname');
        $trails->user_id = data_get($person,'user.id');
        $trails->save();

    }



}

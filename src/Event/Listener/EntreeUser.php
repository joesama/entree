<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EntreeUser
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
    public function handle($table)
    {
        $table->engine = 'InnoDB';
        $table->string('username');
        $table->integer('isAdmin')->default(0);
        $table->unique('username');
    }



}

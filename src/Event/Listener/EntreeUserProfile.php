<?php

namespace Threef\Entree\Event\Listener;

class EntreeUserProfile
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
     * Handle User Profile Creation Event.
     *
     * @param threef.user.profile $event
     *
     * @return void
     */
    public function handle($table)
    {
        // Add additional user profile base on project here
        $table->string('idnumber');
        $table->text('photo');
    }
}

<?php namespace Threef\Entree\Event\Listener;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EntreeLogNotification
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
     * Handle User Insertion Event
     *
     * @param  threef.user.profile  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        $event->channel;
        $event->notifiable;
        $event->notification;

    }


}
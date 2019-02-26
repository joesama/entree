<?php

namespace Joesama\Entree\Event\Listener;

use Illuminate\Notifications\Events\NotificationSent;
use Joesama\Entree\Database\Model\Logs\NotificationLog;

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
     * Handle User Insertion Event.
     *
     * @param joesama.user.profile $event
     *
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        \DB::beginTransaction();

        try {
            $log = new NotificationLog();
            
            $log->channel = $event->channel;
            
            $log->notifiable_type = get_class($event->notifiable);

            $log->notifiable_id = data_get($event, 'notifiable.id');

            if ($event->notification instanceof \Joesama\Entree\Http\Notifications\EntreeMailer):
            $log->title = data_get($event, 'notification.message.title');

            $content = collect(data_get($event, 'notification.message.content'));

            $log->content = $content->toJson();

            $action = collect(data_get($event, 'notification.message.footer'))->merge(data_get($event, 'notification.message.action'));

            $log->action = $action->toJson();
            endif;

            $log->save();

        } catch (\Exception $e) {
            \DB::rollback();
            app('orchestra.messages')->add('error', $e->getMessage());
        }

        \DB::commit();
    }
}

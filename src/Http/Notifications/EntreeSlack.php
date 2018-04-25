<?php

namespace Threef\Entree\Http\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class EntreeSlack extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $chanel = '#general', $type = 'success')
    {
        $this->message = $message;
        $this->chanel = $chanel;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $slack = (new SlackMessage())
                    ->to($this->chanel)
                    ->content($this->message);

        if (strtolower($this->type) === 'error'):
            return $slack->error(); else:
            return $slack->success();
        endif;
    }
}

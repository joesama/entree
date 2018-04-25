<?php

namespace Threef\Entree\Services\Notification;

use JavaScript;
use Threef\Entree\Database\Repository\NotificationData;

/**
 * Announcement Service Class.
 *
 * @author joharijumali@gmail.com
 **/
class Announcement
{
    public function __construct(NotificationData $notify)
    {
        $this->notify = $notify;
    }

    /**
     * Set Announcement To Display.
     *
     * @return void
     *
     * @author
     **/
    public function notify()
    {
        $notification = $this->notify->getNotifications();

        JavaScript::put([
            'notify' => $notification,
        ]);

        return $notification;
    }
} // END class Announcement

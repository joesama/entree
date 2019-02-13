<?php

namespace Joesama\Entree\Database\Model\Logs;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notification_log';

    /**
     * Get all of notification
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}

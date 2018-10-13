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

    // /**
    //  * Relation has one Joesama\Entree\Database\Model\User
    //  **/
    // public function user()
    // {
    //     return $this->belongsTo('Joesama\Entree\Database\Model\User','user_id');
    // }
}

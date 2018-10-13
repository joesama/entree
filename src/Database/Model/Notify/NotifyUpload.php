<?php

namespace Joesama\Entree\Database\Model\Notify;

use Illuminate\Database\Eloquent\Model;

class NotifyUpload extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notify_upload';

    /**
     * Has One relationship with Elesen\Model\Data\Model\Application\ApplicationSetup.
     */
    public function notify()
    {
        return $this->belongsTo(\Joesama\Entree\Database\Model\Notify\Notify::class, 'notify');
    }
}

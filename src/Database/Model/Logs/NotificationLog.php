<?php 
namespace Threef\Entree\Database\Model;

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
    //  * Relation has one Threef\Entree\Database\Model\User
    //  **/
    // public function user()
    // {
    //     return $this->belongsTo('Threef\Entree\Database\Model\User','user_id');
    // } 

}

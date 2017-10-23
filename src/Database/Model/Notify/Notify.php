<?php 
namespace Threef\Entree\Database\Model\Notify;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notify';

    /**
     * Has Many relationship with E\Threef\Entree\Database\Model\Notify\NotifyUpload::class.
     *
     */
    public function upload()
    {
        return $this->hasMany(\Threef\Entree\Database\Model\Notify\NotifyUpload::class,'notify');
    }


}
<?php

namespace Joesama\Entree\Database\Model;

use Illuminate\Database\Eloquent\Model;

class UserAccessTrails extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'access_trail';

    /**
     * Relation has one Joesama\Entree\Database\Model\User.
     **/
    public function user()
    {
        return $this->belongsTo('Joesama\Entree\Database\Model\User', 'user_id');
    }
}

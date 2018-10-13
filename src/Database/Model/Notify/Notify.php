<?php

namespace Joesama\Entree\Database\Model\Notify;

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
     * Has Many relationship with E\Joesama\Entree\Database\Model\Notify\NotifyUpload::class.
     */
    public function upload()
    {
        return $this->hasMany(\Joesama\Entree\Database\Model\Notify\NotifyUpload::class, 'notify');
    }

    /**
     * Scope a query to only include active setup.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

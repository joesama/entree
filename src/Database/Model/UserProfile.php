<?php

namespace Threef\Entree\Database\Model;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['photo'];

    /**
     * Get All Table Listing.
     *
     * @var array
     */
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder();
        // return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}

<?php namespace Threef\Entree\Database\Model;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

	public function getTableColumns() {
		return $this->getConnection()->getSchemaBuilder();
        // return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}

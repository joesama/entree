<?php 
namespace Threef\Entree\Services\Form;

use Illuminate\Http\Request;
use Threef\Entree\Database\Model\UserProfile;


/**
 * User Profile Form
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
class UserProfileForm
{

	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->profiles = $this->setProfileFields(new UserProfile);
	}


	/**
	 * Prepare Profiles Fields
	 *
	 * @return Array
	 * @author 
	 **/
	protected function setProfileFields(UserProfile $profile)
	{
		
		return collect(\Schema::getColumnListing($profile->getTable()))->filter(function ($value, $key) {
					    return !in_array($value, $this->profileDefaultField());
					});
	}

	/**
	 * Profile Default Field
	 *
	 * @return void
	 * @author 
	 **/
	protected function profileDefaultField()
	{
		return ['id','user_id','created_at','updated_at','deleted_at'];
	}



} // END class UserProfileForm
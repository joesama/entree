<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\User;
use Threef\Entree\Database\Model\Role;
use Threef\Entree\Database\Model\UserProfile;
use DB;
/**
 * User Data Manager
 *
 * @package default
 * @author 
 **/
class UserRepo
{

	/**
	 * Retrieve User List
	 *
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 **/
	public function userList($request)
	{
		$search = $request->get('search');
		// dd(app(Role::class)->admin()->id);
		$user = User::when($search, 
				function ($query) use ($search) {
                    return $query->where(function ($query) use ($search) {
			                $query->where('fullname','like', '%' . $search . '%')
			                      ->orWhere('email','like', '%' . $search . '%')
			                      ->orWhere('lastlogin','like', '%' . $search . '%');
			            	})->orderBy('fullname');
                },function ($query) {
                    return $query->orderBy('fullname');
                })->whereHas('roles', function ($query) {
				    $query->whereNotIn('roles.id', [app(Role::class)->admin()->id]);
				})->with('profile','roles');

		return $user->paginate(20);
	}


	/**
	 * Retrieve User Information
	 *
	 * @return void
	 * @author 
	 **/
	public function userInfo($id = NULL)
	{
		return User::with('profile')->find($id);
	}

	/**
	 * List User Role Available
	 *
	 * @return void
	 * @author 
	 **/
	public function userRoleArray()
	{
		return app(\Threef\Entree\Database\Model\Role::class)
			->whereNotIn('roles.id',[app(Role::class)->admin()->id])
			->orderBy('name')
			->pluck('name','id');
	}


	/**
	 * Update Resource Photo Path
	 *
	 * @return void
	 * @author 
	 **/
	public function savePhoto($input, $path)
	{
		$id = $input->get('id');

		if($id):
		
			$profile = UserProfile::where('user_id',$id)->first();

			DB::beginTransaction();

			try{

				$profile->photo = $path;
				$profile->save();

			}catch (\Exception $e)
	        {
	            DB::rollback();
	            throw $e->getMessage();
	        }

	        DB::commit();

        endif;

	}


	/**
	 * Save User Information
	 *
	 * @return void
	 * @author 
	 **/
	public function createUserData($input)
	{

        $user = new User;

        $userTable = data_get($input,'user')->except('roles');

        foreach($userTable as $field => $value):
        	$user->$field = $value;
        endforeach;

        $roles = data_get($input,'user')->get('roles');
        $roles = (is_array($roles)) ? $roles : [$roles];
        
        $user->status   = config('threef/entree::entree.validation') ? User::UNVERIFIED : User::VERIFIED;
        $user->username   = data_get($input,'user')->get(config('threef/entree::entree.username','email'));

        $profileTable = data_get($input,'profile');

        $profile = new UserProfile;

        foreach($profileTable as $field => $value):
        	$profile->$field = $value;
        endforeach;

        DB::beginTransaction();

        try {

			$user->save();
            $user->roles()->sync($roles);
            $user->profile()->save($profile);

		} catch (Exception $e) {

			DB::rollback();
            throw $e->getMessage();
        }

        DB::commit();

        return $user;

	}

    /**
     * Update User Information
     *
     * @return Threef\Entree\Database\Model\User 
     * 
     **/
    public function updateUserData($input)
    {
    	$id = data_get($input,'user')->get('id');

        $user = User::find($id);

        $userTable = data_get($input,'user')->except('roles');

        foreach($userTable as $field => $value):
        	$user->$field = $value;
        endforeach;

        $roles = data_get($input,'user')->get('roles');
        $roles = (is_array($roles)) ? $roles : [$roles];
        
        $user->username   = data_get($input,'user')->get(config('threef/entree::entree.username','email'));

        $profileTable = data_get($input,'profile');

        $profile = UserProfile::where('user_id',$id)->first();

        foreach($profileTable as $field => $value):
        	$profile->$field = $value;
        endforeach;

        DB::beginTransaction();

        try {

			$user->save();
            $user->roles()->sync($roles);
            $user->profile()->save($profile);


        } catch (Exception $e) {

        	DB::rollback();
            throw $e->getMessage();
        }

        DB::commit();

        return $user;

    }


    /**
     * Deactivate User 
     *
     * @return void
     * @param  $id users.id
     **/
    public function deactivate($id)
    {
    	$user = User::find($id);
    	$info = $user;
    	

        DB::beginTransaction();

        try {

            $user->profile()->delete();
			$user->delete();

        } catch (Exception $e) {

        	DB::rollback();
            throw $e->getMessage();
        }

        DB::commit();


    	return $info;
    }


    /**
     * Validate user
     *
     * @return void
     * @author 
     **/
    public function validateUser($token, $email, $password = NULL)
    {

    	$user = User::whereEmail($email)->first();

    	$password = is_null($password) ? str_random(20) : $password;

    	// Validate parameter passed
    	if($user && $user->validateEmail($token,$email)):

    		DB::beginTransaction();

    		try {

    			// Activate the user status
    			$user->password = $password;
    			$user->activate()->save();

    		} catch (Exception $e) {

    			DB::rollback();
	            throw $e->getMessage();
	        }

	        DB::commit();

    		$user->sendWelcomeNotification($password);

    		return $user;

    	else:

    		return FALSE;

    	endif;

    }


} // END class UserRepositories 
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

		$user = User::whereHas('roles', function ($query) {
				    $query->where('roles.id', '<>' ,app(Role::class)->admin()->id);
				})->when($search, 
				function ($query) use ($search) {
                    return $query->where('fullname','like', '%' . $search . '%')
                    		->orWhere('email','like', '%' . $search . '%')
                    		->orWhere('lastlogin','like', '%' . $search . '%')
                    		->orderBy('fullname');
                },function ($query) {
                    return $query->orderBy('fullname');
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

	            dd($e->getMessage());
	            return $e->getMessage();
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
        
        $user->status   = User::UNVERIFIED;
        $user->username   = data_get($input,'user')->get(config('threef/entree::entree.username','email'));

        $profileTable = data_get($input,'profile');

        $profile = new UserProfile;

        foreach($profileTable as $field => $value):
        	$profile->$field = $value;
        endforeach;

        try {

			$user->save();
            $user->roles()->sync($roles);
            $user->profile()->save($profile);

            return $user;

		} catch (Exception $e) {
            dd($e->getMessage());
        }

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

        try {

			$user->save();
            $user->roles()->sync($roles);
            $user->profile()->save($profile);

            return $user;


        } catch (Exception $e) {
            dd($e->getMessage());
        }

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
    	$user->delete();

    	return $info;
    }

} // END class UserRepositories 
<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\User;
use Threef\Entree\Database\Model\Role;
use Threef\Entree\Database\Model\UserProfile;
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

				$profile->profile_photo = $path;
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


} // END class UserRepositories 
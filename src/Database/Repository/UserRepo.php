<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\User;

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

		$user = User::when($search, 
				function ($query) use ($search) {
                    return $query->where('fullname','like', '%' . $search . '%')
                    		->orWhere('email','like', '%' . $search . '%')
                    		->orWhere('lastlogin','like', '%' . $search . '%')
                    		->orderBy('fullname');
                },function ($query) {
                    return $query->orderBy('fullname');
                });

		return $user->paginate(20);
	}


} // END class UserRepositories 
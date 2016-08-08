<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Orchestra\Support\Facades\Foundation;
use Orchestra\Foundation\Processor\User;
use Threef\Entree\Database\Model\User as Eloquent;


/**
 * UserManager class
 *
 * @package default
 * @author 
 **/
class UserManager extends User
{

	/**
	 * Process User Update
	 *
	 * @return mixed
	 **/
	public function userCreate(Request $request)
	{

		$input = $request->except('_token');

        $user = new Eloquent;

        $userTable = collect($input);
        $userTable->forget('roles');
        $userTable->forget('status');
        $userTable->forget('password');

        foreach($userTable as $field => $value):
        	$user->$field = $value;
        endforeach;

        $roles = data_get($input,'roles');
        $roles = (is_array($roles)) ? $roles : [$roles];
        $input['roles'] = $roles;

        $user->status   = Eloquent::UNVERIFIED;
        $user->password   = data_get($input,'password');

        try {

			$this->saving($user, $input, 'create');

		} catch (Exception $e) {
            dd($e->getMessage());
        }
	}


	/**
	 * Process User Update
	 *
	 * @return mixed
	 **/
	public function userUpdate(Request $request)
	{
		$id = $request->segment(4);
		$input = $request->except('_token');
		
        $user = Eloquent::findOrFail($id);

        ! empty($input['password']) && $user->password = data_get($input,'password');

        $userTable = collect($input);
        $userTable->forget('roles');

        $roles = data_get($input,'roles');
        $roles = (is_array($roles)) ? $roles : [$roles];
        $input['roles'] = $roles;

        foreach($userTable as $field => $value):
        	$user->$field = $value;
        endforeach;

        try {

		$this->saving($user, $input, 'update');

		} catch (Exception $e) {
            dd($e->getMessage());
        }
	}








} // END class UserManager 
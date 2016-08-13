<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Orchestra\Support\Facades\Foundation;
use Orchestra\Foundation\Processor\User;
use Threef\Entree\Database\Model\User as Eloquent;
use Threef\Entree\Database\Model\UserProfile as Profile;
use Carbon\Carbon;


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

        $delegated = $this->delegateUserInfo($request);

        return $this->processUser($delegated , $id);

	}


    /**
     * Delegation of user table 
     *
     * @return Array $input
     *
     **/
    public function delegateUserInfo($request)
    {
        $user = collect([]);
        $profile = collect([]);

        foreach($request->except('_token') as $field => $value){

            if(str_is('profile*', $field)){
                $profile->put(str_replace("profile_", "", $field),$value);
            }else{
                $user->put(str_replace("user_", "", $field),$value);
            }

        }

        return compact('user','profile');
    }


    /**
     * Processing User Information
     *
     * @return Threef\Entree\Database\Model\User 
     * 
     **/
    public function processUser($collections , $id)
    {

        $user = Eloquent::findOrFail($id);

        $input = data_get($collections,'user');

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

        $profile = data_get($collections,'profile');
        $profile->put('updated_at',Carbon::now());

        $user->profile()->update($profile->toArray());


        } catch (Exception $e) {
            dd($e->getMessage());
        }


        return $user;

    }








} // END class UserManager 
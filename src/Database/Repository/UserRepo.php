<?php

namespace Joesama\Entree\Database\Repository;

use DB;
use Joesama\Entree\Database\Model\Role;
use Joesama\Entree\Database\Model\User;
use Joesama\Entree\Database\Model\UserProfile;

/**
 * User Data Manager.
 *
 * @author
 **/
class UserRepo
{
    /**
     * Retrieve User List.
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
                        $query->where('fullname', 'like', '%'.$search.'%')
                                  ->orWhere('email', 'like', '%'.$search.'%')
                                  ->orWhere('lastlogin', 'like', '%'.$search.'%');
                    })->orderBy('fullname');
                }, function ($query) {
                    return $query->orderBy('fullname');
                })->whereHas('roles', function ($query) {
                    $query->whereNotIn('roles.id', [app(Role::class)->admin()->id]);
                })->with('profile', 'roles');

        return $user->paginate(20);
    }

    /**
     * Retrieve User Information.
     *
     * @return void
     *
     * @author
     **/
    public function userInfo($id = null)
    {
        return User::with('profile')->find($id);
    }

    /**
     * List User Role Available.
     *
     * @return void
     *
     * @author
     **/
    public function userRoleArray()
    {
        return app(\Joesama\Entree\Database\Model\Role::class)
            ->whereNotIn('roles.id', [app(Role::class)->admin()->id])
            ->orderBy('name')
            ->pluck('name', 'id');
    }

    /**
     * Update Resource Photo Path.
     *
     * @return void
     *
     * @author
     **/
    public function savePhoto($input, $path)
    {
        $id = $input->get('id');

        if ($id):

            $user = User::find($id);

        DB::beginTransaction();

        try {
            $user->photo = $path;
            $user->save();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e->getMessage();
        }

        DB::commit();

        endif;
    }

    /**
     * Save User Information.
     *
     * @return void
     *
     * @author
     **/
    public function createUserData($input)
    {
        $user = new User();

        $userTable = data_get($input, 'user')->except('roles');

        foreach ($userTable as $field => $value):
            $user->$field = $value;
        endforeach;

        $roles = data_get($input, 'user')->get('roles');
        $roles = (is_array($roles)) ? $roles : [$roles];

        $user->status = config('joesama/entree::entree.validation') ? User::UNVERIFIED : User::VERIFIED;

        if (config('joesama/entree::entree.username', 'email') == 'email'):
        $user->username = data_get($input, 'user')->get(config('joesama/entree::entree.username', 'email'));
        endif;

        $profileTable = data_get($input, 'profile');

        $profile = new UserProfile();

        foreach ($profileTable as $field => $value):
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
     * Update User Information.
     *
     * @return Joesama\Entree\Database\Model\User
     *
     **/
    public function updateUserData($input)
    {
        $id = data_get($input, 'user')->get('id');

        $user = User::find($id);

        $userTable = data_get($input, 'user')->except('roles');

        foreach ($userTable as $field => $value):
            $user->$field = $value;
        endforeach;

        $roles = data_get($input, 'user')->get('roles');
        // $roles = (is_array($roles)) ? $roles : $roles;

        if (config('joesama/entree::entree.username', 'email') == 'email'):
        $user->username = data_get($input, 'user')->get(config('joesama/entree::entree.username', 'email'));
        endif;

        $profileTable = data_get($input, 'profile');

        $profile = UserProfile::where('user_id', $id)->first();

        foreach ($profileTable as $field => $value):
            $profile->$field = $value;
        endforeach;

        DB::beginTransaction();

        try {
            $user->save();

            if (!is_null($roles)):
                $user->roles()->sync($roles);
            endif;

            if (!is_null($profile)):
                $user->profile()->save($profile);
            endif;
        } catch (Exception $e) {
            DB::rollback();

            throw $e->getMessage();
        }

        DB::commit();

        return $user;
    }

    /**
     * Deactivate User.
     *
     * @param  $id users.id
     *
     * @return void
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
     * Validate user.
     *
     * @return void
     *
     * @author
     **/
    public function validateUser($token, $email, $password = null)
    {
        $user = User::whereEmail($email)->first();

        $password = is_null($password) ? str_random(20) : $password;

        // Validate parameter passed
        if ($user && $user->validateEmail($token, $email)):

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

        return $user; else:

            return false;

        endif;
    }
} // END class UserRepositories

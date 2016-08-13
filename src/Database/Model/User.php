<?php namespace Threef\Entree\Database\Model;

use Orchestra\Model\User as OrchestraUser;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
/**
 * Extension of 
 *
 * @package default
 * @author 
 **/
class User extends OrchestraUser 
{
	 

    /**
     * Relation has one Threef\Entree\Database\Model\UserProfile
     **/
    public function profile()
    {
        return $this->hasOne('Threef\Entree\Database\Model\UserProfile','fk_user');
    } 

	public function getFullnameAttribute($value)
    {
        return strtoupper($value);
    }

	 
	public function getStatusAttribute($value)
    {

        return trans('entree::entree.user.status.'.$value);
    }


} // END class User extends OrchestraUser 
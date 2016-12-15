<?php namespace Threef\Entree\Database\Model;

use Orchestra\Model\User as OrchestraUser;
use Illuminate\Notifications\Notifiable;
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
	 
    use Notifiable;

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

        return trans('threef/entree::entree.user.status.'.$value);
    }

/**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    /**
     * Slack Notification End Point
     *
     * @return void
     * @author joharijumali@gmail.com
     **/
    public function routeNotificationForSlack()
    {
        return 'https://hooks.slack.com/services/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';
    }


} // END class User extends OrchestraUser 
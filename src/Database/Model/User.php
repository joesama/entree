<?php namespace Threef\Entree\Database\Model;

use Orchestra\Foundation\Auth\User as OrchestraUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Threef\Entree\Http\Notifications\ResetPasswordMessage;
use Threef\Entree\Http\Notifications\EntreeMailer;
use Carbon\Carbon;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'lastlogin'
    ];

    /**
     * Relation has one Threef\Entree\Database\Model\UserProfile
     **/
    public function profile()
    {
        return $this->hasOne('Threef\Entree\Database\Model\UserProfile','user_id');
    } 

    public function getFullnameAttribute($value)
    {
        return strtoupper($value);
    }

	public function getLastloginAttribute($value)
    {
        return Carbon::parse($this->attributes['lastlogin'])->diffForHumans(Carbon::now());
    }

	public function getStatusAttribute($value)
    {
        return trans('threef/entree::entree.user.status.'.$value);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return array
     */
    public function getAuthIdentifiersName()
    {
        return [config('threef/entree::entree.username','email')];
    }

    /**
     * Get the username of the user.
     *
     * @return string
     */
    public function getUserName()
    {
        return strtolower($this->attributes[config('threef/entree::entree.username','email')]);
    }

    /**
     * Get Validation Token
     *
     * @return string
     **/
    public function getValidateAttribute($value)
    {
        return encrypt( $this->attributes['status'].$this->attributes['email'] );
    }

    /**
     * Validate Passed Info
     *
     * @return void
     * @author 
     **/
    public function validateEmail($token, $email)
    {
        return decrypt( $token ) == $this->attributes['status'].$email; 
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @param  string|null  $provider
     *
     * @return void
     */
    public function sendPasswordResetNotification($token, $provider = null)
    {
        $message = collect([]);
        $message->put("level","success");
        $message->put("title",trans('threef/entree::mail.reset.title'));
        $message->put("content" , collect([
         trans('threef/entree::mail.reset.form')
        ]));

        $message->put("footer" , collect([
         trans('threef/entree::mail.reset.expired', ['time' => config('auth.reminder.expire', 60) ]),
        ]));

        $message->put("action" , collect([ trans('threef/entree::mail.reset.title') => handles('entree::forgot/reset/'.$token) ]));

        $this->notify(new EntreeMailer($message));
    }

    /**
     * Send the user registered notification.
     *
     * @param  string|null  $password
     *
     * @return void
     */
    public function sendWelcomeNotification($password = null)
    {

        $message = collect([]);
        $message->put("level","success");
        $message->put("title",trans('threef/entree::mail.validated.title'));
        $message->put("content" , collect([
            title_case(trans('threef/entree::mail.validated.success')),
            trans('threef/entree::mail.validated.username', ['username' => $this->getUserName() ]),
            trans('threef/entree::mail.validated.password', ['password' => $password ]),
        ]));

        $message->put("footer" , collect([
            title_case(trans('threef/entree::mail.validated.form')),
        ]));

        $message->put("action" , collect([ trans('threef/entree::mail.login') => handles('entree::login/') ]));

        $this->notify(new EntreeMailer($message));
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
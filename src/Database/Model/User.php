<?php

namespace Joesama\Entree\Database\Model;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Orchestra\Foundation\Auth\User as OrchestraUser;
use Joesama\Entree\Http\Notifications\EntreeMailer;

/**
 * Extension of.
 *
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
        'lastlogin',
    ];
    
    protected $guarded = ['id'];

    /**
     * Relation has one Joesama\Entree\Database\Model\UserProfile.
     **/
    public function profile()
    {
        return $this->hasOne('Joesama\Entree\Database\Model\UserProfile', 'user_id');
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
        return trans('joesama/entree::entree.user.status.'.$value);
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return array
     */
    public function getAuthIdentifiersName():array
    {
        return [config('joesama/entree::entree.username', 'email')];
    }

    /**
     * Get the username of the user.
     *
     * @return string
     */
    public function getUserName()
    {
        return strtolower($this->attributes[config('joesama/entree::entree.username', 'email')]);
    }

    /**
     * Get Validation Token.
     *
     * @return string
     **/
    public function getValidateAttribute($value)
    {
        return encrypt($this->attributes['status'].$this->attributes['email']);
    }

    /**
     * Validate Passed Info.
     *
     * @return void
     *
     * @author
     **/
    public function validateEmail($token, $email)
    {
        return decrypt($token) == $this->attributes['status'].$email;
    }

    /**
     * Send the password reset notification.
     *
     * @param string      $token
     * @param string|null $provider
     *
     * @return void
     */
    public function sendPasswordResetNotification($token, $provider = null)
    {
        $message = collect([]);
        $message->put('level', 'success');
        $message->put('title', trans('joesama/entree::mail.reset.title'));
        $message->put('content', collect([
         trans('joesama/entree::mail.reset.form'),
        ]));

        $message->put('footer', collect([
         trans('joesama/entree::mail.reset.expired', ['time' => config('auth.reminder.expire', 60)]),
        ]));

        $message->put('action', collect([trans('joesama/entree::mail.reset.title') => handles('entree::forgot/reset/'.$token)]));

        $this->notify(new EntreeMailer($message));
    }

    /**
     * Send the user registered notification.
     *
     * @param string|null $password
     *
     * @return void
     */
    public function sendWelcomeNotification($password = null)
    {
        $message = collect([]);
        $message->put('level', 'success');
        $message->put('title', trans('joesama/entree::mail.validated.title'));
        $message->put('content', collect([
            title_case(trans('joesama/entree::mail.validated.success')),
            trans('joesama/entree::mail.validated.username', ['username' => $this->getUserName()]),
            trans('joesama/entree::mail.validated.password', ['password' => $password]),
        ]));

        $message->put('footer', collect([
            title_case(trans('joesama/entree::mail.validated.form')),
        ]));

        $message->put('action', collect([trans('joesama/entree::mail.login') => handles('entree::login/')]));

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
     * Slack Notification End Point.
     *
     * @return void
     *
     * @author joharijumali@gmail.com
     **/
    public function routeNotificationForSlack()
    {
        return 'https://hooks.slack.com/services/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';
    }
} // END class User extends OrchestraUser

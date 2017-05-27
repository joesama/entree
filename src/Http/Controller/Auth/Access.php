<?php namespace Threef\Entree\Http\Controller\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Orchestra\Foundation\Processor\AuthenticateUser;
use Orchestra\Foundation\Processor\DeauthenticateUser;
use Threef\Entree\Http\Processor\UserManager;
use Orchestra\Contracts\Auth\Command\ThrottlesLogins as ThrottlesCommand;
use Orchestra\Contracts\Auth\Listener\AuthenticateUser as AuthenticateListener;
use Orchestra\Contracts\Auth\Listener\ThrottlesLogins as ThrottlesListener;
use Orchestra\Contracts\Auth\Listener\DeauthenticateUser as DeauthenticateListener;

class Access extends Controller implements AuthenticateListener,DeauthenticateListener, ThrottlesListener
{

    /**
     * POST Login the user.
     *
     * POST (:orchestra)/login
     *
     * @return mixed
     */
    public function login(Request $request, AuthenticateUser $authenticate, ThrottlesCommand $throttles )
    {

        $input = $request->only(['username', 'password', 'remember']);
        $throttles->setRequest($request)->setLoginKey('username');
        $input['status'] = 1;

        return $authenticate->login($this, $input, $throttles);
    }

    /**
     * Logout the user.
     *
     * DELETE (:bundle)/login
     *
     * @return mixed
     */
    public function logout(DeauthenticateUser $deauthenticate)
    {
        return $deauthenticate->logout($this);
    }

    /**
     * GET default entree landing page
     *
     * @return mixed
     **/
    public function home()
    {
        return view('threef/entree::entree.home');
    }


    /**
     * Validate User Account
     *
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     **/
    public function emailValidation(Request $request)
    {
        return app(UserManager::class)->validateUserRegistration($this,$request);
    }


    /**
     * Response to user email validation failed .
     *
     * @param  \Illuminate\Support\MessageBag|array  $errors
     *
     * @return mixed
     */
    public function userEmailValidationRespond($messages){

        return view('threef/entree::entree.auth.validation', compact('messages'));
    }


    /**
     * Response to user log-in trigger failed validation .
     *
     * @param  \Illuminate\Support\MessageBag|array  $errors
     *
     * @return mixed
     */
    public function userLoginHasFailedValidation($errors){
        
        return $this->redirectWithErrors(handles('threef/entree::login'), $errors);
    }

    /**
     * Response to user log-in trigger has failed authentication.
     *
     * @param  array  $input
     *
     * @return mixed
     */
    public function userLoginHasFailedAuthentication(array $input){

        $message = trans('threef/entree::respond.respond.login.fail-auth');

        return $this->redirectWithMessage(handles('threef/entree::login'), $message, 'error')->withInput();
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  array  $input
     * @param  int  $seconds
     *
     * @return mixed
     */
    public function sendLockoutResponse(array $input, $seconds){
        
        $message = trans('auth.throttle', ['seconds' => $seconds]);

        return $this->redirectWithMessage(handles('threef/entree::login'), $message, 'danger')->withInput();
    }

    /**
     * Response to user has logged in successfully.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     *
     * @return mixed
     */
    public function userHasLoggedIn(Authenticatable $user){

        messages('success', trans('orchestra/foundation::response.credential.logged-in'));

        event('threef.user.login', [$user]);

        return Redirect::intended(handles('threef/entree::home'));
    }

    /**
     * Response to user has logged out successfully.
     *
     * @return mixed
     */
    public function userHasLoggedOut(){

        messages('success', trans('orchestra/foundation::response.credential.logged-out'));

        return Redirect::intended(handles(Input::get('redirect', 'threef/entree::login')));
    }

}

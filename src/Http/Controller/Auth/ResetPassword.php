<?php namespace Threef\Entree\Http\Controller\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Orchestra\Contracts\Auth\Listener\PasswordReset;
use Orchestra\Contracts\Auth\Listener\PasswordResetLink;
use Threef\Entree\Http\Processor\PasswordManager;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class ResetPassword extends Controller implements PasswordReset,PasswordResetLink
{

	public function __construct(PasswordManager $password) {

		$this->manager = $password;
	}

	/**
     * Get Password Reset Page
     *
     * @return mixed
     **/
    public function getSelfReset()
    {
        return  $this->viewForgot();
    }


    /**
     * User Request Self Reset Password
     * Validate requested emel for reset link submission 
     * POST : ('forgot') 
     * @return mixed
     **/
    public function postSelfReset(Request $request)
    {
    	return $this->manager->selfReset($this, $request);
    }


    /**
     * Self Reset Form
     * GET : ('forgot/reset/$token')
     * @return mixed
     **/
    public function getResetPassword($token)
    {
    	return $this->viewResetPassword()->with('token', $token);

    }


    /**
     * Validate Password Submission And Update New Password
     * POST : ('forgot/reset/$token')
     * @return mixed
     **/
    public function postResetPassword(Request $request)
    {
    	return $this->manager->resetPassword($this, $request);
    }


    /**
     * Sending Reset Password Email By Admin
     * POST : ('user/reset/$id')
     * @return void
     * @author 
     **/
    public function adminResetPassword($id)
    {
    	return $this->manager->resetByAdmin($this, $id);
    }

    /**
     * Response when reset password failed.
     *
     * @param  string  $response
     *
     * @return mixed
     */
    public function passwordResetHasFailed($response){
    	
    	$message = trans($response);
    	$token   = Input::get('token');

        return $this->redirectWithErrors(handles('threef/entree::password/reset/'.$token), $message);
    }


    /**
     * Response when reset password succeed.
     *
     * @param  string  $response
     *
     * @return mixed
     */
    public function passwordHasReset($response){
    	
    	$message = trans($response);

        return $this->redirectWithMessage(handles('threef/entree::login'), $message);
    }

    /**
     * Response when request password failed on validation.
     *
     * @param  \Illuminate\Support\MessageBag|array  $errors
     *
     * @return mixed
     */
    public function resetLinkFailedValidation($errors){

        return $this->redirectWithErrors(handles('threef/entree::forgot'), $errors);
    }

    /**
     * Response when request reset password failed.
     *
     * @param  string  $response
     *
     * @return mixed
     */
    public function resetLinkFailed($response){
    	
    	$message = trans($response);

        return $this->redirectWithErrors(handles('threef/entree::forgot'), $message);
    }

    /**
     * Response when request reset password succeed.
     *
     * @param  string  $response
     *
     * @return mixed
     */
    public function resetLinkSent($response){
    	
    	$message = trans($response);

        return $this->redirectWithMessage(handles('threef/entree::forgot'), $message);
    }


    /**
     * Response when request reset password succeed.
     *
     * @param  string  $response
     *
     * @return mixed
     */
    public function resetByAdminLinkSent($response){
    	
    	$message = trans($response);

        return $this->redirectWithMessage(handles('threef/entree::user'), $message);
    }

    /**
     * View Password Self Reset Request Page
     *
     * @return view
     **/
    public function viewForgot()
    {
        return view('threef/entree::entree.auth.forgot');
    }

    /**
     * View Request Password Reset Page
     *
     * @return view
     **/
    public function viewResetPassword()
    {
        return view('threef/entree::entree.auth.reset');
    }

} // END class ResetPassword 
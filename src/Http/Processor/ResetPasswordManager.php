<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Support\Facades\Hash;
use Orchestra\Support\Str;
use Orchestra\Contracts\Auth\Listener\PasswordReset;
use Orchestra\Contracts\Auth\Listener\PasswordResetLink;
use Orchestra\Foundation\Processor\Account\PasswordBroker;
use Illuminate\Contracts\Auth\PasswordBroker as Password;
use Threef\Entree\Http\Validation\User as Validator;
use Threef\Entree\Database\Model\User;
/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class ResetPasswordManager 
{

	public function __construct(Password $password, Validator $validator, PasswordBroker $orchestraBroker) {

		$this->password = $password;
		$this->validator = $validator;
		$this->broker = $orchestraBroker;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function selfReset($listener, $request)
	{
		$input = $request->input();

        $validation = $this->validator->on('reset')->with($input);

        if ($validation->fails()) {
            return $listener->resetLinkFailedValidation($validation->getMessageBag());
        }
        
        $data   = ['email' => $input['email']];

        $response = $this->password->sendResetLink($data);

        if ($response != Password::RESET_LINK_SENT) {
            return $listener->resetLinkFailed($response);
        }

        return $listener->resetLinkSent($response,$input['email']);

	}

	/**
	 * Reset Password via Orchestra\Foundation\Processor\Account\PasswordBroker
	 * 
	 * @return mixed
	 **/
	public function resetPassword($listener, $request)
	{	
 		return $this->broker->update($listener, $request->except('_token'));
	}	

	/**
	 * Reset Password By Admin
	 * 
	 * @return mixed
	 **/
	public function resetByAdmin($control, $id)
	{	
		$user = User::find($id)->toArray();

		$site   = app('orchestra.platform.memory')->get('site.name', '3FRSB : PSS');

 		$response = $this->password->sendResetLink($user, function ($mail) use ($site) {
            $mail->subject(trans('orchestra/foundation::email.forgot.request', ['site' => $site]));
        });


        return $control->resetByAdminLinkSent($response);


	}	

} // END class PasswordManager 
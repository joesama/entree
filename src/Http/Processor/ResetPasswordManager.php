<?php

namespace Joesama\Entree\Http\Processor;

use Illuminate\Contracts\Auth\PasswordBroker as Password;
use Orchestra\Foundation\Processors\Account\PasswordBroker;
use Joesama\Entree\Database\Model\User;
use Joesama\Entree\Http\Validation\User as Validator;

/**
 * undocumented class.
 *
 * @author
 **/
class ResetPasswordManager
{
    public function __construct(Password $password, Validator $validator, PasswordBroker $orchestraBroker)
    {
        $this->password = $password;
        $this->validator = $validator;
        $this->broker = $orchestraBroker;
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function selfReset($listener, $request)
    {
        $input = $request->input();

        $validation = $this->validator->on('reset')->with($input);

        if ($validation->fails()) {
            return $listener->resetLinkFailedValidation($validation->getMessageBag());
        }

        $data = ['email' => $input['email']];

        $response = $this->password->sendResetLink($data);

        if ($response != Password::RESET_LINK_SENT) {
            return $listener->resetLinkFailed($response);
        }

        return $listener->resetLinkSent($response, $input['email']);
    }

    /**
     * Reset Password via Orchestra\Foundation\Processor\Account\PasswordBroker.
     *
     * @return mixed
     **/
    public function resetPassword($listener, $request)
    {
        return $this->broker->update($listener, $request->except('_token'));
    }

    /**
     * Reset Password By Admin.
     *
     * @return mixed
     **/
    public function resetByAdmin($control, $id)
    {
        $user = collect(User::find($id)->toArray())->only(config('joesama/entree::entree.username', 'email'));

        $site = app('orchestra.platform.memory')->get('site.name', '3FRSB : PSS');

        $response = $this->password->sendResetLink($user->toArray(), function ($mail) use ($site) {
            $mail->subject(trans('joesama/entree::emails.password', ['site' => $site]));
        });

        return $control->resetByAdminLinkSent($response);
    }
} // END class PasswordManager

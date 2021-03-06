<?php

namespace Joesama\Entree\Http\Controller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Orchestra\Contracts\Foundation\Listener\Account\PasswordUpdater as Listener;
use Orchestra\Foundation\Processor\Account\PasswordUpdater as Processor;

class Password extends Controller implements Listener
{
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Retrieve Password Change Page.
     *
     * @return mixed
     **/
    public function edit()
    {
        set_meta('title', trans('joesama/entree::entree.password.reset.title'));

        return $this->processor->edit($this);
    }

    /**
     * Save Updated Password.
     *
     * @return mixed
     **/
    public function update()
    {
        return $this->processor->update($this, Input::all());
    }

    /**
     * Response when validation on change password failed.
     * {@inherit}.
     *
     * @param \Illuminate\Support\MessageBag|array $errors
     *
     * @return mixed
     */
    public function updatePasswordFailedValidation($errors)
    {
        return $this->redirectWithErrors(handles('joesama/entree::password'), $errors);
    }

    /**
     * Response when verify current password failed.
     * {@inherit}.
     *
     * @return mixed
     */
    public function verifyCurrentPasswordFailed()
    {
        $message = trans('orchestra/foundation::response.account.password.invalid');

        return $this->redirectWithMessage(handles('joesama/entree::password'), $message, 'error');
    }

    /**
     * Response when update password failed.
     * {@inherit}.
     *
     * @param array $errors
     *
     * @return mixed
     */
    public function updatePasswordFailed(array $errors)
    {
        $message = trans('orchestra/foundation::response.db-failed', $errors);

        return $this->redirectWithMessage(handles('joesama/entree::password'), $message, 'error');
    }

    /**
     * Response when update password succeed.
     *
     * @return mixed
     */
    public function passwordUpdated()
    {
        $message = trans('orchestra/foundation::response.account.password.update');

        return $this->redirectWithMessage(handles('joesama/entree::home'), $message);
    }

    /**
     * Abort request when user mismatched.
     *
     * @return mixed
     */
    public function abortWhenUserMismatched()
    {
        return $this->suspend(500);
    }

    /**
     * undocumented function.
     *
     * @return view
     **/
    public function showPasswordChanger(array $data)
    {
        return view('joesama/entree::entree.auth.password', $data);
    }
}

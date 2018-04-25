<?php

namespace Threef\Entree\Event\Listener\Notifications;

use Threef\Entree\Database\Model\User;
use Threef\Entree\Http\Notifications\EntreeMailer;

class NewUserEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param Threef\Entree\Database\Model\User $user
     *
     * @return void
     */
    public function handle(User $user)
    {
        $token = $user->validate;
        $email = $user->email;

        $message = collect([]);
        $message->put('level', 'info');
        $message->put('title', trans('threef/entree::mail.validation'));
        $message->put('content', collect([
         trans('threef/entree::mail.thank'),
         trans('threef/entree::mail.proceed'),
        ]));

        $message->put('footer', collect([
         trans('threef/entree::mail.click'),
        ]));

        $message->put('action', collect([trans('threef/entree::mail.validation') => handles('threef/entree::validate/'.$token.'/?email='.$email)]));

        $user->notify(new EntreeMailer($message));
    }
}

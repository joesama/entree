<?php

namespace Joesama\Entree\Event\Listener\Notifications;

use Joesama\Entree\Database\Model\User;
use Joesama\Entree\Http\Notifications\EntreeMailer;

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
     * @param Joesama\Entree\Database\Model\User $user
     *
     * @return void
     */
    public function handle(User $user)
    {
        $token = $user->validate;
        $email = $user->email;

        $message = collect([]);
        $message->put('level', 'info');
        $message->put('title', trans('joesama/entree::mail.validation'));
        $message->put('content', collect([
         trans('joesama/entree::mail.thank'),
         trans('joesama/entree::mail.proceed'),
        ]));

        $message->put('footer', collect([
         trans('joesama/entree::mail.click'),
        ]));

        $message->put('action', collect([trans('joesama/entree::mail.validation') => handles('joesama/entree::validate/'.$token.'/?email='.$email)]));

        $user->notify(new EntreeMailer($message));
    }
}

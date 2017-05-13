<?php

namespace Threef\Entree\Event\Listener\Notifications;

use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @return void
     */
    public function handle(User $user)
    {

        $message = collect([]);
        $message->put("level","info");
        $message->put("title",trans('threef/entree::mail.validation'));
        $message->put("content" , collect([
         trans('threef/entree::mail.thank'),
         trans('threef/entree::mail.proceed')
        ]));

        $message->put("footer" , collect([
         trans('threef/entree::mail.click'),
        ]));

        $message->put("action" , collect([ "Login" => handles('threef/entree::login') ]));

        $user->notify(new EntreeMailer($message));


    }

    
}

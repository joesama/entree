<?php

namespace Threef\Entree\Http\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Orchestra\Notifications\Messages\MailMessage;


class EntreeMailer extends Notification implements ShouldQueue
{
    use Queueable;

    protected  $view = 'threef/entree::entree.emails.layouts.simple';
    protected  $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message , $view = FALSE)
    {
        $this->message = $message;
        $this->view = ($view) ? $view : $this->view;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $mailMessage = new MailMessage;

        if($this->view) $mailMessage->view = $this->view;

        $mailMessage->subject($this->message->get('title', 'Email From ' . memorize('site.name')));
        $mailMessage->title($this->message->get('title', 'Email From ' . memorize('site.name')));
        $mailMessage->level($this->message->get('level'));
        $mailMessage->greeting(trans('threef/entree::mail.greeting') . ' ' .$notifiable->fullname. ', ');

        $content  = $this->message->get('content',[]);

        foreach($content as $cont){
            $mailMessage->line($cont);
        }

        $action = $this->message->get('action', FALSE);

        if($action):
        foreach($action as $title => $uri){
            $mailMessage->action($title,$uri);
        }
        endif;


        $footer  = $this->message->get('footer',[]);
        foreach($footer as $foot){
            $mailMessage->line($foot);
        }

        // dd($mailMessage);

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        
    }
}

<?php

namespace Joesama\Entree\Database\Repository;

use Joesama\Entree\Database\Model\Logs\NotificationLog as Model;

/**
 * Notification Log.
 *
 * @author joharijumali@gmail.com
 **/
class NotificationLog
{
    /**
     * Return All Maill Submit To User.
     *
     * @return void
     *
     * @author
     **/
    public function mail()
    {
        return Model::where('notifiable_type', 'Joesama\Entree\Database\Model\User')
                ->where('notifiable_id', \Auth::user()->id)
                ->get()
                ->map(function($mails){
                    return collect([
                        'title' => $mails->title,
                        'header' => collect(json_decode($email->content))->first(),
                        'content' => collect(json_decode($email->content)),
                        'date' => \Carbon\Carbon::parse($email->created_at)->format('d-m-Y'),
                        'aging' => \Carbon\Carbon::parse($email->created_at)->diffForHumans(),
                    ]);
                });
    }

    /**
     * Update Mail Read Status.
     *
     * @return void
     *
     * @author
     **/
    public function read($id)
    {
        \DB::beginTransaction();

        try {
            $mail = Model::find($id);
            $mail->read = 1;
            $mail->save();
        } catch (\Exception $e) {
            \DB::rollback();
            app('orchestra.messages')->add('error', $e->getMessage());
        }

        \DB::commit();
    }
} // END class NotificationLog

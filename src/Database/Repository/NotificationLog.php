<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\Logs\NotificationLog;

/**
 * Notification Log
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
class NotificationLog 
{

	/**
	 * Return All Maill Submit To User
	 *
	 * @return void
	 * @author 
	 **/
	public function getUserMail()
	{

		return NotificationLog::where('notifiable','Threef\Entree\Database\Model\User')
				->where('notifiable_id',\Auth::user()->id)->get();

	}


	/**
	 * Update Mail Read Status
	 *
	 * @return void
	 * @author 
	 **/
	public function readMail($id)
	{
		\DB::beginTransaction();

        try{

			$mail = NotificationLog::find($id);
			$mail->read = 1;
			$mail->save();

        }catch (\Exception $e)
        {
            \DB::rollback();
            app('orchestra.messages')->add('error', $e->getMessage());
        }

        \DB::commit();

	}

} // END class NotificationLog 
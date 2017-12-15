<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\Logs\NotificationLog as Model;

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
	public function mail()
	{

		return Model::where('notifiable','Threef\Entree\Database\Model\User')
				->where('notifiable_id',\Auth::user()->id)->get();

	}


	/**
	 * Update Mail Read Status
	 *
	 * @return void
	 * @author 
	 **/
	public function read($id)
	{
		\DB::beginTransaction();

        try{

			$mail = Model::find($id);
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
<?php 
namespace Threef\Entree\Database\Repository;

use Threef\Entree\Database\Model\Notify\Notify;
use Threef\Entree\Database\Model\Notify\NotifyUpload;
use DB;

/**
 * Notification Data Manager
 *
 * @package threef/entree
 * @author 
 **/
class NotificationData 
{


	/**
	 * Search Data Notification
	 *
	 * @return void
	 * @author 
	 **/
	public function searchNotifyData($request)
	{
		$search = $request->get('search');

		$notify = Notify::when($search, 
		function ($query) use ($search) {
            return $query->where(function ($query) use ($search) {
	                $query->where('title','like', '%' . $search . '%');
	            	})->orderBy('created_at','asc');
        },function ($query) {
            return $query->orderBy('created_at','desc');
        })->with('upload');

        return $notify->paginate(20);
	}


	/**
	 * Save Data Notification
	 *
	 * @return void
	 * @author 
	 **/
	public function saveNotification($request)
	{

		$id = $request->segment(3);

		$notification = (!is_null($id)) ? Notify::find($id) : new Notify;

		DB::beginTransaction();

		try{

			$notification->title = ucwords($request->get('desc'));
			$notification->content = $request->get('content');
			$notification->active = $request->get('active',1);
			$notification->save();

		}catch (\Exception $e)
        {
            DB::rollback();
            throw $e->getMessage();
        }

        DB::commit();

	}


	/**
	 * Retrieve Notification Data
	 *
	 * @return void
	 * @author 
	 **/
	public function getNotification($id)
	{
		return Notify::with('upload')->find($id);
	}

	/**
	 * Retrieve All Active Notification Data
	 *
	 * @return void
	 * @author 
	 **/
	public function getNotifications()
	{
		return Notify::with('upload')->active()->get();
	}

	/**
	 * Retrieve Notification Image
	 *
	 * @return void
	 * @author 
	 **/
	public function getNotificationImage($notify)
	{
		return NotifyUpload::where('notify',$notify)->get();
	}


	/**
	 * Save Upload Data
	 *
	 * @return void
	 * @author 
	 **/
	public function saveNotifyImage($notify, $desc ,$path)
	{
		DB::beginTransaction();

		try{

			$upload = new NotifyUpload;
			$upload->notify = $notify;
			$upload->description = $desc;
			$upload->path = $path;
			$upload->active = 1;
			$upload->save();

		}catch (\Exception $e)
        {
            DB::rollback();
            throw $e->getMessage();
        }

        DB::commit();

	}


	/**
	 * Remove Uploaded Image
	 *
	 * @return void
	 * @author 
	 **/
	public function removeNotifyImage($notify, $img)
	{
		$image = NotifyUpload::where('id',$img)->where('notify',$notify)->first();

		$path = data_get($image,'path');

		$image->delete();

		return $path;

	}

} // END class NotificationData 
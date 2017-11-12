<?php 
namespace Threef\Entree\Services\Notification;

use Threef\Entree\Database\Repository\NotificationData;
use JavaScript;


/**
 * Announcement Service Class
 *
 * @package threef/entree
 * @author joharijumali@gmail.com
 **/
class Announcement 
{

	public function __construct(NotificationData $notify)
	{
		$this->notify = $notify;
	}


	/**
	 * Set Announcement To Display
	 *
	 * @return void
	 * @author 
	 **/
	public function notify()
	{

		$notification = $this->notify->getNotifications();
		
		JavaScript::put([
			'notify' => $notification,
		]);

		return $notification;
	}

} // END class Announcement 
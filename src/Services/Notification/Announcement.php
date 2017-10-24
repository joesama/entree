<?php 
namespace Threef\Entree\Services\Notification;

use Threef\Entree\Database\Repository\NotificationData;
use JavaScript;


/**
 * Announcement Service Class
 *
 * @package default
 * @author 
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
		JavaScript::put([
			'notify' => $this->notify->getNotifications(),
		]);
	}

} // END class Announcement 
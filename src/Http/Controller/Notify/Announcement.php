<?php

namespace Joesama\Entree\Http\Controller\Notify;

use Illuminate\Http\Request;
use Joesama\Entree\Http\Controller\Controller;
use Joesama\Entree\Http\Processor\Notify\NotificationManager;

/**
 * Announcement Packages.
 *
 * @author
 **/
class Announcement extends Controller
{
    public function __construct(NotificationManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * List All Registered Notification.
     *
     * @return void
     *
     * @author
     **/
    public function notificationList(Request $request)
    {
        $table = $this->manager->listNotification($request);

        return view('joesama/entree::entree.datagrid.list', compact('table'));
    }

    /**
     * Retrieve Notification Data.
     *
     * @return void
     *
     * @author
     **/
    public function notificationData(Request $request)
    {
        return $this->manager->getNotifyData($request);
    }

    /**
     * Upload Notification Image.
     *
     * @return void
     *
     * @author
     **/
    public function notificationUpload($id, Request $request)
    {
        return $this->manager->uploadNotifyImage($id, $request);
    }

    /**
     * Remove Notification Image.
     *
     * @return void
     *
     * @author
     **/
    public function removeUpload($id, $item)
    {
        return $this->manager->removeUploadImage($id, $item);
    }

    /**
     * Notification Form.
     *
     * @return void
     *
     * @author
     **/
    public function notification(Request $request)
    {
        set_meta('title', trans('joesama/entree::title.notify.title'));

        $data = $this->manager->notifyDataByID($request->segment(3));


        return view('joesama/entree::entree.notify.notify', compact('data'));
    }

    /**
     * Save Notification Data.
     *
     * @return void
     *
     * @author
     **/
    public function saveNotification(Request $request)
    {
        $notification = $this->manager->manageNotificationData($request);

        return redirect_with_message(
                handles('joesama/entree::notify/form/'.data_get($notification, 'id')),
                trans('joesama/entree::respond.data.success', ['form' => trans('joesama/entree::entree.notify.title')]),
                'success');
    }
} // END class Announcement

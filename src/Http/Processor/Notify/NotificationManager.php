<?php

namespace Joesama\Entree\Http\Processor\Notify;

use File;
use Joesama\Entree\Database\Repository\NotificationData;
use VueGrid;
use Joesama\Entree\Services\Upload\FileUploader;

/**
 * Manage All Notification Process.
 *
 * @author
 **/
class NotificationManager
{
    public function __construct(NotificationData $data)
    {
        $this->data = $data;
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function listNotification($request)
    {
        $columns = [
            ['field' => 'title', 'title' => trans('joesama/entree::entree.notify.desc'), 'style' => 'text-left'],
            ['field' => 'active', 'title' => trans('joesama/entree::entree.notify.active'), 'style' => 'text-center', 'iconic' => true],
        ];

        $grid = new VueGrid();
        $grid->setColumns($columns);
        $grid->setModel($this->getNotifyData($request));
        $grid->add(handles('joesama/entree::notify/form/'.$request->segment(3)), trans('joesama/entree::entree.notify.title'));
        $grid->apiUrl(handles('joesama/entree::notify/data'));
        $grid->action([
                ['action' => trans('joesama/entree::datagrid.buttons.edit'),
                  'url'   => handles('joesama/entree::notify/form/'),
                  'icons' => 'fa fa-pencil',
                  'key'   => 'id',  ],
                // [ 'action' => trans('joesama/entree::datagrid.buttons.reset-pwd') ,
                //   'url' => handles('joesama/entree::user/reset'),
                //   'icons' => 'fa fa-key',
                //   'key' => 'id'   ],
                // [ 'delete' => trans('joesama/entree::datagrid.buttons.delete') ,
                //   'url' => handles('joesama/entree::user/delete/'),
                //   'icons' => 'fa fa-trash',
                //   'key' => 'id'  ]
            ], true);

        return $grid->build();
    }

    /**
     * Get Notification Data.
     *
     * @return void
     *
     * @author
     **/
    public function getNotifyData($request)
    {
        return $this->data->searchNotifyData($request);
    }

    /**
     * Get Notification By ID.
     *
     * @return void
     *
     * @author
     **/
    public function notifyDataByID($id)
    {
        return $this->data->getNotification($id);
    }

    /**
     * Manage Notification Data.
     *
     * @return void
     *
     * @author
     **/
    public function manageNotificationData($request)
    {
        return $this->data->saveNotification($request);
    }

    /**
     * Upload Image.
     *
     * @return void
     *
     * @author
     **/
    public function uploadNotifyImage($id, $request)
    {
        if ($request->file('photo')->isValid()) :

            $file = new FileUploader($request->file('photo'), $this);

        $uploaded = $this->data->saveNotifyImage($id, $this->data->getNotification($id)->title, $file->destination(), $file->destination());

        return response()->json(['upload' => $this->data->getNotificationImage($id)]);

        endif;
    }

    /**
     * Remove Uploaded Imaged.
     *
     * @return void
     *
     * @author
     **/
    public function removeUploadImage($id, $item)
    {
        $removeD = $this->data->removeNotifyImage($id, $item);

        File::delete(public_path($removeD));

        return response()->json(['upload' => $this->data->getNotificationImage($id)]);
    }
} // END class NotificationManager

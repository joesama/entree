<?php 
namespace Threef\Entree\Http\Processor\Notify;

use Threef\Entree\Database\Repository\NotificationData;
use Threef\Entree\Services\DataGrid\VueDatagrid;
use Threef\Entree\Services\Upload\FileUploader;
use File;

/**
 * Manage All Notification Process
 *
 * @package threef/enteree
 * @author 
 **/
class NotificationManager 
{


	public function __construct(NotificationData $data)
	{
		$this->data = $data;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function listNotification($request)
	{
		$columns = [
            [ 'field' => 'title', 'title' => trans('threef/entree::entree.notify.desc') , 'style' => 'text-left'],
            [ 'field' => 'content', 'title' => trans('threef/entree::entree.notify.content') , 'style' => 'text-left'], 
            [ 'field' => 'active', 'title' => trans('threef/entree::entree.notify.active') , 'style' => 'text-center' , 'iconic' => TRUE]
        ];

        $grid = new VueDatagrid;
        $grid->setColumns($columns);
        $grid->setModel($this->getNotifyData($request));
        $grid->add(handles('threef/entree::notify/form/'.$request->segment(3)), trans('threef/entree::entree.notify.title'));
        $grid->apiUrl(handles('threef/entree::notify/data'));
        $grid->action([
                [ 'action' => trans('threef/entree::datagrid.buttons.edit') ,
                  'url' => handles('threef/entree::notify/form/'),
                  'icons' => 'fa fa-pencil',
                  'key' => 'id'  ],
                // [ 'action' => trans('threef/entree::datagrid.buttons.reset-pwd') ,
                //   'url' => handles('threef/entree::user/reset'),
                //   'icons' => 'fa fa-key',
                //   'key' => 'id'   ],
                // [ 'delete' => trans('threef/entree::datagrid.buttons.delete') ,
                //   'url' => handles('threef/entree::user/delete/'),
                //   'icons' => 'fa fa-trash',
                //   'key' => 'id'  ]
            ],TRUE);

        return $grid->build();
	}


	/**
	 * Get Notification Data
	 *
	 * @return void
	 * @author 
	 **/
	public function getNotifyData($request)
	{
		return $this->data->searchNotifyData($request);
	}


	/**
	 * Get Notification By ID
	 *
	 * @return void
	 * @author 
	 **/
	public function notifyDataByID($id)
	{
		return $this->data->getNotification($id);
	}


	/**
	 * Manage Notification Data
	 *
	 * @return void
	 * @author 
	 **/
	public function manageNotificationData($request)
	{
		return $this->data->saveNotification($request);

	}


	/**
	 * Upload Image
	 *
	 * @return void
	 * @author 
	 **/
	public function uploadNotifyImage($id, $request)
	{
		if ($request->file('photo')->isValid()) :

            $file = new FileUploader($request->file('photo'), $this);

            $uploaded = $this->data->saveNotifyImage($id,$this->data->getNotification($id)->title,$file->destination());

            return response()->json(['upload' => $this->data->getNotificationImage($id) ]);

        endif;
	}


	/**
	 * Remove Uploaded Imaged
	 *
	 * @return void
	 * @author 
	 **/
	public function removeUploadImage($id,$item)
	{
		$removeD = $this->data->removeNotifyImage($id,$item);

		File::delete(public_path($removeD));

		return response()->json(['upload' => $this->data->getNotificationImage($id)]);
	}

} // END class NotificationManager 
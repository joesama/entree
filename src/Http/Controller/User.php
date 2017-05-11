<?php namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use Orchestra\Foundation\Http\Controllers\UsersController;
use Threef\Entree\Http\Processor\UserManager;
use Orchestra\Foundation\Processor\User as Processor;



class User extends UsersController
{

    public function __construct(UserManager $manager, Processor $parent) {

        parent::__construct($parent);

        $this->parent = $parent;
        $this->manager = $manager;

    }

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex(Request $request)
    {
        set_meta('page-header',trans('threef/entree::entree.user.manage'));
        
        $table = $this->manager->userList($request);

        return view('threef/entree::entree.datagrid.list',compact('table'));
    }


    /**
     * Retrieve User List
     *
     * @return void
     * @author 
     **/
    public function dataApi(Request $request)
    {
        return $this->manager->dataList($request);
    }


    /**
     * Response to Update User Form
     *
     * @return mixed
     **/
    public function getUserUpdate($id)
    {
        set_meta('page-header',trans('threef/entree::entree.user.manage'));

        return $this->manager->userUpdate($id);
    }

    /**
     * Response to Update User Form
     *
     * @return mixed
     **/
    public function getUserCreation(Request $request)
    {
        set_meta('page-holder',trans('entree::entree.user.manage'));

        $data = $this->manager->userCreation($request);

        return view('threef/entree::entree.user.form',$data);

    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function getUserCreate(Request $request)
    {
        return $this->manager->userCreate($request);
    }


    /**
     * Upload User Photo
     *
     * @return void
     * @author 
     **/
    public function savePhoto(Request $request)
    {
        return $this->manager->uploadPhoto($request);
    }

}

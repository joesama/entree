<?php namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use Orchestra\Foundation\Http\Controllers\UsersController;
use Threef\Entree\Http\Processor\UserManager;
use Orchestra\Foundation\Processor\User as Processor;
use Threef\Entree\DataGrid\UsersDataTable;



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
    public function getIndex(UsersDataTable $datatables)
    {
        set_meta('page-header',trans('threef/entree::entree.user.manage'));
        
        return $datatables->render('threef/entree::entree.user.datatables');
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
        set_meta('page-header',trans('entree::entree.user.manage'));

        return $this->manager->userCreation($request);
    }

}

<?php

namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use Orchestra\Foundation\Http\Controllers\UsersController;
use Orchestra\Foundation\Processor\User as Processor;
use Threef\Entree\Http\Processor\UserManager;

class User extends UsersController
{
    public function __construct(UserManager $manager, Processor $parent)
    {
        parent::__construct($parent);

        $this->parent = $parent;
        $this->manager = $manager;
    }

    /**
     * Displaying landing page.
     *
     * @return mixed
     **/
    public function getIndex(Request $request)
    {
        set_meta('page-header', trans('threef/entree::entree.user.manage'));

        $table = $this->manager->userList($request);

        return view('threef/entree::entree.datagrid.list', compact('table'));
    }

    /**
     * Retrieve User List.
     *
     * @return void
     *
     * @author
     **/
    public function dataApi(Request $request)
    {
        return $this->manager->dataList($request);
    }

    /**
     * Response to Create User Form.
     *
     * @return mixed
     **/
    public function getUserCreation(Request $request)
    {
        // set_meta('title',trans('entree::entree.user.manage'));

        $data = $this->manager->userCreation($request);

        return view('threef/entree::entree.user.form', $data);
    }

    /**
     * Save User Information.
     *
     * @return void
     *
     * @author
     **/
    public function postUserCreation(Request $request)
    {
        return $this->manager->userCreate($request);
    }

    /**
     * Response to Update User Form.
     *
     * @return mixed
     **/
    public function getUserUpdate(Request $request)
    {
        set_meta('title', trans('threef/entree::entree.user.edit'));

        $data = $this->manager->userCreation($request);

        return view('threef/entree::entree.user.form', $data);
    }

    /**
     * Update User Information.
     *
     * @return void
     *
     * @author
     **/
    public function postUserUpdate(Request $request)
    {
        return $this->manager->userUpdate($request);
    }

    /**
     * Remove User From List.
     *
     * @return void
     *
     * @author
     **/
    public function getRemoveUser($id)
    {
        return $this->manager->deactivateUser($id);
    }
}

<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Threef\Entree\Database\Model\User;
use Threef\Entree\DataGrid\Grid;

use yajra\Datatables\Datatables;


/**
 * UserManager class
 *
 * @package default
 * @author 
 **/
class UserManager
{

	public function __construct(Grid $grid){

		$this->grid = $grid;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function listUser($control, Request $request)
	{	

		$html = $this->grid->attach($request,User::select('*'));

		return $control->listUsers(compact('html'));
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function getUserData($request)
	{
		$users = User::select(['id', 'fullname', 'email', 'password', 'created_at', 'updated_at']);

        return Datatables::of($users)
            // ->addColumn('action', function ($user) {
            //     return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            // })
            ->editColumn('id', 'ID: {{$id}}')
            ->removeColumn('password')
            ->make(true);
    
	}



} // END class UserManager 
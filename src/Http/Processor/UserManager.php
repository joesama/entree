<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Threef\Entree\Database\Model\User;
use Threef\Entree\DataGrid\Grid;

use Threef\Entree\DataGrid\UsersDataTable;


/**
 * UserManager class
 *
 * @package default
 * @author 
 **/
class UserManager
{

	public function __construct(UsersDataTable $grid){

		$this->grid = $grid;
	}

	/**
	 * Show All Registered User
	 *
	 * @return $grid  UsersDataTable
	 **/
	public function listUser(Request $request)
	{	
		return $this->grid->render('threef/entree::entree.user.datatables');
	}


	/**
	 * Process User Update
	 *
	 * @return mixed
	 **/
	public function userUpdate($id)
	{
		dump($id);
	}




} // END class UserManager 
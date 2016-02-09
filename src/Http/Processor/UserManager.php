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
		return $this->grid->render('entree::entree.user.datatables');
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function userPage(Request $request)
	{
		dump($request);
	}




} // END class UserManager 
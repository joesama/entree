<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Threef\Entree\Database\Model\Role;
use Threef\Entree\EntreeMenu;

use Orchestra\Support\Str;
use Orchestra\Support\Keyword;
use Orchestra\Contracts\Authorization\Factory;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class MenuAccessManager 
{

	public function __construct(EntreeMenu $menu, Role $roles, Factory $acl)
	{
		$this->menu = $menu;
		$this->roles = $roles;
		$this->acl = $acl;
	}


	/**
	 * Manage User Menu Access
	 *
	 * @return void
	 **/
	public function menuManager($controller,$request)
	{
		$acl  = $this->acl->get('entree');

		$actionRoles = $this->getRolesActions($acl);

		$menu = $this->menu->menu();

		$roles = $this->roles->pluck('name','id');

		return $controller->viewMain(compact('menu','roles','action','actionRoles'));


	}


	/**
	 * Update Manage User Menu Access
	 *
	 * @return void
	 **/
	public function manageAccess($request)
	{   
		$acl  = $this->menu->acl();

		$params = collect($request->except('_token'));

		$acl->actions()->detach($params->keys());
		$acl->actions()->attach($params->keys()->toArray());

		$roles = $this->roles->pluck('name','id');

		$acl->roles()->detach($roles->toArray());
		$acl->roles()->attach($roles->toArray());
		$acl->sync();

		$roles->each(function($roleName,$roleId)use($params,$acl){

			$roleName = Keyword::make($roleName)->getSlug();

			$params->each(function ($item, $key) use ($roleId,$acl,$roleName){

				if(in_array($roleId,$item)):
					$acl->allow($roleName, $key);
				endif;
			});

		});

		return redirect(handles('threef/entree::menu'));

	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function getRolesActions($acl)
	{
		$actionAvail = collect([]);

		foreach($acl->actions()->get() as $action){

			$access = collect([]);

			$roles = $this->roles->pluck('name','id');

			foreach($roles as $roleId => $role){

				$role = Keyword::make($role)->getSlug();

				if($acl->check($role,$action)):
					$access->push($roleId);
				endif;

			}

			$actionAvail->put($action, $access);

		}

		return $actionAvail;

	}

} // END class MenuAccessManager 
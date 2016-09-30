<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
		$access = $this->menu->acl();

		$roles = $this->roles->where('id','!=',1)->pluck('name','id');

		return $controller->viewMain(compact('menu','roles','access','actionRoles'));


	}


	/**
	 * Update Manage User Menu Access
	 *
	 * @return void
	 **/
	public function manageAccess($request)
	{   
		$acl  = $this->menu->acl();

		$params = $request->except('_token');

		$actions = $this->getAclActions();
		$roles = $this->getAclRoles();


		if(empty($acl->actions()->get()) && empty($acl->roles()->get())):

			$acl->actions()->attach($actions);
			$acl->roles()->attach($roles);
			$acl->sync();

		endif;

        foreach ($roles as $roleKey => $roleName) {
            foreach ($actions as $actionKey => $actionName) {
           	 	$menu = Keyword::make($actionName)->getSlug();
				$role = Keyword::make($roleName)->getSlug();
                $value = ('yes'=== Arr::get($params, "{$menu}_{$role}", 'no'));
                dump($menu . ':' . $role . '->' . $value);
                $acl->allow($roleName, $actionName, $value);
            }
        }


		return redirect_with_message(handles('threef/entree::menu'),trans('threef/entree::respond.respond.saved'),'success');

	}


	/**
	 * Get All Action For ACL
	 *
	 * @return Illuminate\Support\Collection
	 **/
	protected function getAclActions()
	{
		$menus  = $this->menu->menu();

		$actions = collect([]);

		foreach($menus as $menu):
			if($menu->id !== 'home'):
			$action = Keyword::make($menu->id)->getSlug();
			$actions->push($action);

			foreach($menu->childs as $submenumenu):
				$action = Keyword::make($menu->id.$submenumenu->id)->getSlug();
				$actions->push($action);
			endforeach;
			endif;
		endforeach;


		return $actions;
	}

	/**
	 * Get All Role For ACL
	 *
	 * @return Illuminate\Support\Collection
	 **/
	protected function getAclRoles()
	{
		return $this->roles->where('id','!=',1)->pluck('name','id')
				 ->transform(function ($item, $key) {
					    return Keyword::make($item)->getSlug();;
				});
	}



	/**
	 * Get Action Priveleges For Roles
	 *
	 * @return Illuminate\Support\Collection
	 **/
	protected function getRolesActions($acl)
	{
		$actionAvail = collect([]);

		foreach($acl->actions()->get() as $action){
			$access = collect([]);

			$roles = $this->getAclRoles();

			foreach($roles as $roleId => $role){
				if($acl->check($role,$action)):
					$access->push($roleId);
				endif;

			}

			$actionAvail->put($action, $access);

		}

		return $actionAvail;

	}

} // END class MenuAccessManager 
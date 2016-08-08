<?php namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Orchestra\Support\Str;
use Orchestra\Support\Facades\Foundation;
use Threef\Entree\Database\Model\Role;
use Threef\Entree\EntreeMenu;
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
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function menuManager($controller,$request)
	{
		$acl  = $this->acl->get('entree');

		$actionRoles = $this->getRolesActions($acl);

		$menu = $this->menu->menu();

		$roles = $this->roles->pluck('name','id');

		return $controller->viewMain(compact('menu','roles','action'));


	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function manageAccess($request)
	{   
		$acl  = $this->menu->acl();

		dump($acl);

		$params = collect($request->except('_token'));

		$acl->actions()->attach($params->keys()->toArray());

		dump($params);

		$roles = $this->roles->pluck('name','id');
		$roles->transform(function ($item, $key) {
		    return strtolower($item);
		});

		$acl->roles()->attach($roles->toArray());

		$roles->each(function($name,$id)use($params,$acl){

			dump('======================='. $name . '=======================');

			$menu = collect([]);

			$params->each(function ($item, $key) use ($id,$menu){

				if(in_array($id,$item)):
					$menu->push($key);
				endif;
			});

			$acl->allow($name, $menu->toArray());

		});


		$role = \Auth::user()->getRoles();

		return redirect('threef/entree::menu');

	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function getRolesActions()
	{

		// $instances  = $acl;
		$aclList = $acl->acl();
		$action = $acl->actions();
		$roleList = $acl->roles();
		dump($aclList);
		dump($roleList);

		foreach(){


		}

		dd($action);
		// $rolesAttached = collect($acl->roles()->get())->reject(function ($role) {
  //           return in_array($role, ['guest']);
  //       })->map(function ($slug) {
  //           $name = Str::humanize($slug);

  //           return compact('slug', 'name');
  //       });

		// dump($acl->actions()->get());

	}

} // END class MenuAccessManager 
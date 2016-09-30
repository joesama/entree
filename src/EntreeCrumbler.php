<?php namespace Threef\Entree;

use Threef\Entree\EntreeMenu;


/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class EntreeCrumbler
{

	public function __construct(EntreeMenu $menu)
	{
		$this->menu = $menu->menu();
	}


	/**
	 * undocumented function
	 *
	 * @return Illuminate\Support\Collection
	 **/
	public function crumbler()
	{
		return $this->breaded();
	}


	/**
	 * Retrieve Breadcrumb
	 *
	 * @return void
	 **/
	protected function breaded()
	{
		$path = $this->currentPath();

		$bread = collect([]);

		foreach($this->menu as $menu){

			if($menu->id === 'home'){
				$bread->put('main',$menu);
			}

			if($menu->link === $path){
				$bread->put('path',$menu);
				return $bread;
			}

			foreach($menu->childs as $submenu){
				if($submenu->link === $path){

					$bread->put('path',$submenu);
					$bread->put('head',$menu);

					return $bread;
				}
			}
		}


		dd($bread);


	}


	/**
	 * Retrieve Current Path
	 *
	 **/
	protected function currentPath()
	{
		return url()->current();
	}

} // END class EntreeCrumbler 


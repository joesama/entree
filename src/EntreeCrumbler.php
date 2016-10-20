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
		$this->path = $this->currentPath();
	}


	/**
	 * Get Breadcrumb
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
	 * @return Illuminate\Support\Collection
	 **/
	protected function breaded()
	{

		$bread = collect([]);

		foreach($this->menu as $menu){

			if($menu->id === 'home'):
				$bread->put('main',$menu);
			endif;

			if($menu->link === $this->path):
				$bread->put('path',$menu);
				return $bread;
			endif;

			$this->childCrumbler($menu,$menu->childs,$bread);

		}

		return $bread;

	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function childCrumbler($parent,$childs,$bread)
	{
		foreach($childs as $submenu){
			if($submenu->link === $this->path):

				$bread->put('path',$submenu);
				$bread->put('head',$parent);
				return $bread;
			else:

			$this->childCrumbler($submenu,$submenu->childs,$bread);

			endif;
		}
	}


	/**
	 * Retrieve Current Path
	 **/
	protected function currentPath()
	{
		return url()->current();
	}

} // END class EntreeCrumbler 


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
	/**
	* First URL segment 
	**/
	protected $firstPart;

	/**
	* Second URL segment 
	**/
	protected $secondPart;

	public function __construct(EntreeMenu $menu)
	{
		$this->menu = $menu->menu();
		$this->path = $this->currentPath();
		$this->firstPart = request()->segment(1);
		$this->secondPart  = request()->segment(2);
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
		$emptyParent = collect([]);

		foreach($this->menu as $menu){

			$dataParent = data_get($menu,$this->firstPart,data_get($menu,$this->secondPart));

			if($emptyParent->isEmpty() && !is_null($dataParent)):
				$emptyParent->push($dataParent);
			endif;

			if($menu->id === 'home'):
				$bread->put('main',$menu);
			endif;

			if($menu->link === $this->path):
				$bread->put('path',$menu);
				return $bread;
			endif;

			$this->childCrumbler($menu,$menu->childs,$bread,$emptyParent);


		}

		if(!$bread->get('head',FALSE) && !$bread->get('path',FALSE)):

			$path = collect([]);
			$path->title=get_meta('title');

			$bread->put('head',$emptyParent->first());
			$bread->put('path',$path);
		endif;

		return $bread;

	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function childCrumbler($parent,$childs,$bread,$emptyParent)
	{
		$dataParent = data_get($childs,$this->firstPart,data_get($childs,$this->secondPart));

		if($emptyParent->isEmpty() && !is_null($dataParent)):
			$emptyParent->push($dataParent);
		endif;

		foreach($childs as $submenu){

			if($submenu->link === $this->path):
				$bread->put('path',$submenu);
				$bread->put('head',$parent);
				return $bread;
			else:

			$this->childCrumbler($submenu,$submenu->childs,$bread,$emptyParent);

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


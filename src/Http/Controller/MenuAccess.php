<?php namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Threef\Entree\Http\Processor\MenuAccessManager;

class MenuAccess extends Controller
{

	function __construct(MenuAccessManager $manager)
	{
		$this->manager = $manager;
	}

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex(Request $request)
    {
        return  $this->manager->menuManager($this,$request);
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function menuAccess(Request $request)
    {
    	return  $this->manager->manageAccess($request);
    }


    /**
     * Landing Page View
     *
     * @return view
     **/
    public function viewMain($data)
    {
        set_meta('page-header',trans('threef/entree::title.config.menu'));
        
        return view('threef/entree::entree.menu.menu',$data);
    }
}
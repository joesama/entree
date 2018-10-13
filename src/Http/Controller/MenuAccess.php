<?php

namespace Joesama\Entree\Http\Controller;

use Illuminate\Http\Request;
use Joesama\Entree\Http\Processor\MenuAccessManager;

class MenuAccess extends Controller
{
    public function __construct(MenuAccessManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Displaying landing page.
     *
     * @return mixed
     **/
    public function getIndex(Request $request)
    {
        return  $this->manager->menuManager($this, $request);
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function menuAccess(Request $request)
    {
        return  $this->manager->manageAccess($request);
    }

    /**
     * Landing Page View.
     *
     * @return view
     **/
    public function viewMain($data)
    {
        set_meta('page-header', trans('joesama/entree::title.config.menu'));

        return view('joesama/entree::entree.menu.menu', $data);
    }
}

<?php

namespace Joesama\Entree\Http\Controller\Report;

use App\Http\Controllers\Controller;

class ReporterAccess extends Controller
{
    /**
     * Displaying landing page.
     *
     * @return mixed
     **/
    public function getIndex()
    {
        set_meta('page-header', trans('joesama/entree::report.menu.report-assign'));

        return  $this->viewMain();
    }

    /**
     * Landing Page View.
     *
     * @return view
     **/
    public function viewMain()
    {
        return view('joesama/entree::entree.report.access');
    }
}

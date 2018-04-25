<?php

namespace Threef\Entree\Http\Controller\Report;

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
        set_meta('page-header', trans('threef/entree::report.menu.report-assign'));

        return  $this->viewMain();
    }

    /**
     * Landing Page View.
     *
     * @return view
     **/
    public function viewMain()
    {
        return view('threef/entree::entree.report.access');
    }
}

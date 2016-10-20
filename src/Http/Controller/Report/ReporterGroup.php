<?php 

namespace Threef\Entree\Http\Controller\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReporterGroup extends Controller
{

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex()
    {
        set_meta('page-header',trans('threef/entree::report.menu.report-group'));
        
        return  $this->viewMain();
    }



    /**
     * Landing Page View
     *
     * @return view
     **/
    public function viewMain()
    {
        return view('threef/entree::entree.report.category');
    }
}

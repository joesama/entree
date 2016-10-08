<?php 

namespace Threef\Entree\Http\Controller\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Reporter extends Controller
{

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex()
    {
        return  $this->viewMain();
    }



    /**
     * Landing Page View
     *
     * @return view
     **/
    public function viewMain()
    {
        return view('threef/entree::entree.index');
    }
}

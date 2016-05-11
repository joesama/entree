<?php namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Entrance extends Controller
{

    // public function __construct() {
        
    //     $this->middleware('guest', ['only' => ['getIndex']]);
    // }

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
        return view('entree::entree.index');
    }
}
<?php namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use Threef\Entree\Services\Notification\Announcement;

class Entrance extends Controller
{

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex()
    {   
        $announcer = \Threef\Entree\Facades\Announcer::notify();

        return  $this->viewMain(compact('announcer'));
    }



    /**
     * Landing Page View
     *
     * @return view
     **/
    public function viewMain($data)
    {
        return view('threef/entree::entree.index',$data);
    }
}

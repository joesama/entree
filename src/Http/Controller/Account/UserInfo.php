<?php 
namespace Threef\Entree\Http\Controller\Account;

use Illuminate\Http\Request;
use Threef\Entree\Http\Processor\UserManager;
use Threef\Entree\Http\Controller\Controller;

class UserInfo extends Controller
{

    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex()
    {
        set_meta('title',trans('threef/entree::title.account.info'));

        $user = \Auth::user();

        return view('threef/entree::entree.account.info',compact('user'));
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function saveInfo(Request $request)
    {
        return $this->manager->updateAccountInfo($request);
    }

    /**
     * Upload User Photo
     *
     * @return void
     * @author 
     **/
    public function savePhoto(Request $request)
    {
        return $this->manager->uploadPhoto($request);
    }
}

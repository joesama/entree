<?php

namespace Joesama\Entree\Http\Controller\Account;

use Illuminate\Http\Request;
use Joesama\Entree\Http\Controller\Controller;
use Joesama\Entree\Http\Processor\UserManager;

class UserInfo extends Controller
{
    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Displaying landing page.
     *
     * @return mixed
     **/
    public function getIndex()
    {
        set_meta('title', trans('joesama/entree::title.account.info'));

        $user = \Auth::user();

        return view('joesama/entree::entree.account.info', compact('user'));
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function saveInfo(Request $request)
    {
        return $this->manager->updateAccountInfo($request);
    }

    /**
     * Upload User Photo.
     *
     * @return void
     *
     * @author
     **/
    public function savePhoto(Request $request)
    {
        return $this->manager->uploadPhoto($request);
    }
}

<?php namespace Threef\Entree\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Orchestra\Foundation\Http\Controllers\UsersController;
use Threef\Entree\Http\Processor\UserManager;
use Orchestra\Foundation\Processor\User as Processor;

class User extends UsersController
{

    public function __construct(UserManager $manager, Processor $parent) {

        parent::__construct($parent);

        $this->processor = $parent;

    }

    /**
     * Displaying landing page
     *
     * @return mixed
     **/
    public function getIndex(Request $request)
    {
        set_meta('page-header',trans('entree::entree.user.manage'));
        
        return $this->processor->index($this, Input::all());
    }


    /**
     * Response when list users page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function showUsers(array $data)
    {
 
        event('entree.user.list: action',[$data['table']]);

        return view('entree::entree.user.list', $data);
    }



}

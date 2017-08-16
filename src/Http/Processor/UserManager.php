<?php 
namespace Threef\Entree\Http\Processor;

use Illuminate\Http\Request;
use Orchestra\Support\Facades\Foundation;
use Orchestra\Foundation\Processor\User;
use Threef\Entree\Database\Model\User as Eloquent;
use Threef\Entree\Database\Model\UserProfile as Profile;
use Carbon\Carbon;
use Threef\Entree\Services\DataGrid\VueDatagrid;
use Threef\Entree\Services\Upload\FileUploader;
use Threef\Entree\Database\Repository\UserRepo;
use Threef\Entree\Services\Form\UserProfileForm;
use Threef\Entree\Http\Validation\Profile as Validator;

/**
 * UserManager class
 *
 * @package default
 * @author 
 **/
class UserManager extends User
{

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function __construct(UserRepo $repo, Validator $validate)
    {
        $this->repo = $repo;
        $this->validator = $validate;
    }


    /**
     * Listing All User
     *
     * @return void
     * @author 
     **/
    public function userList($request)
    {

        $columns = [
            [ 'field' => 'fullname', 'title' => trans('threef/entree::entree.user.grid.fullname')  , 'style' => 'text-left'],
            [ 'field' => 'username', 'title' => trans('threef/entree::entree.user.grid.username') , 'style' => 'text-left'], 
            [ 'field' => 'email', 'title' => trans('threef/entree::entree.user.grid.email') , 'style' => 'text-left'], 
            [ 'field' => 'roles:name', 'title' => trans('threef/entree::entree.user.grid.role') , 'style' => 'text-left multi'], 
            [ 'field' => 'status', 'title' => trans('threef/entree::entree.user.grid.status'), 'style' => 'text-center'], 
            [ 'field' => 'lastlogin', 'title' => trans('threef/entree::entree.user.grid.lastlogin'), 'style' => 'text-left date']
        ];

        $grid = new VueDatagrid;
        $grid->setColumns($columns);
        $grid->setModel($this->dataList($request));
        $grid->apiUrl(handles('threef/entree::user/data'));
        $grid->add(handles('threef/entree::user/new'), trans('threef/entree::entree.user.action.new'));
        $grid->action([
                [ 'action' => trans('threef/entree::datagrid.buttons.edit') ,
                  'url' => handles('threef/entree::user'),
                  'icons' => 'fa fa-pencil',
                  'key' => 'id'  ],
                [ 'action' => trans('threef/entree::datagrid.buttons.reset-pwd') ,
                  'url' => handles('threef/entree::user/reset'),
                  'icons' => 'fa fa-key',
                  'key' => 'id'   ],
                [ 'delete' => trans('threef/entree::datagrid.buttons.delete') ,
                  'url' => handles('threef/entree::user/delete/'),
                  'icons' => 'fa fa-trash',
                  'key' => 'id'  ]
            ],TRUE);

        return $grid->build();

    }


    /**
     * User Data API
     *
     * @return void
     * @author 
     **/
    public function dataList($request)
    {
        return $this->repo->userList($request);
    }



    /**
     * User Data Form
     *
     * @return void
     * @author 
     **/
    public function userCreation($request)
    {
        $user = $this->repo->userInfo($request->segment(2));
        $roles = $this->repo->userRoleArray();
        $validation = config('threef/entree::entree.validation');
        $username = config('threef/entree::entree.username');

        return compact('user','roles','validation','username');
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function userInfo($id)
    {
        return $this->repo->userInfo($id);
    }


	/**
	 * Process User Update
	 *
	 * @return mixed
	 **/
	public function userCreate($request)
	{

        $validation = $this->validator->on('create')
            ->with($request->input());

        if($validation->fails()):

            return redirect_with_message(
                handles('threef/entree::user/new'),
                trans('threef/entree::respond.data.failed', [ 'form' => trans('threef/entree::entree.user.new') ]),
                'danger')
            ->withInput()
            ->withErrors($validation->getMessageBag());

        endif;

        $input = $this->delegateUserInfo($request);
        $user = $this->repo->createUserData($input);

        if(config('threef/entree::entree.validation')):

            event('threef.email.user: new', [$user]);

        else:

            $user->sendWelcomeNotification(data_get($input,'user.password'));

        endif;

        return redirect_with_message(
                handles('threef/entree::user'),
                trans('threef/entree::respond.data.success', [ 'form' => trans('threef/entree::entree.user.new') ]),
                'success');

	}


    /**
     * Upload Photo & Update Resources Photo Path 
     *
     * @return void
     * @author 
     **/
    public function uploadPhoto($request)
    {
        if ($request->file('photo')->isValid()) :

            $file = new FileUploader($request->file('photo'), $this);

            $this->repo->savePhoto($request,$file->destination());

            return response()->json(['path' => $file->destination()]);

        endif;
    }


	/**
	 * Process User Update
	 *
	 * @return mixed
	 **/
	public function userUpdate($request)
	{

        $validation = $this->validator->on('update')
            ->bind(['userId' => $request->get('id')])
            ->with($request->input());

        if($validation->fails()):

            return redirect_with_message(
                handles('threef/entree::user/'.$request->get('id')),
                trans('threef/entree::respond.data.failed', [ 'form' => trans('threef/entree::entree.user.edit') ]),
                'danger')
            ->withInput()
            ->withErrors($validation->getMessageBag());

        endif;

        $input = $this->delegateUserInfo($request);

        $user = $this->repo->updateUserData($input);

        return redirect_with_message(
                handles('threef/entree::user'),
                trans('threef/entree::respond.data.success', [ 'form' => trans('threef/entree::entree.user.edit') ]),
                'success');

	}


    /**
     * Delegation of user & profile table 
     *
     * @return Array $input
     *
     **/
    protected function delegateUserInfo($request)
    {
        $user = collect([]);
        $profile = collect([]);

        $data = new UserProfileForm($request);

        foreach($request->except('_token') as $field => $value){

            if($value !== ""):
            if(data_get($data,'profiles')->contains($field)){
                $profile->put($field,$value);
            }else{
                $user->put($field,$value);
            }
            endif;

        }

        return compact('user','profile');
    }



    /**
     * Deactivate User
     *
     * @return void
     * @param $id users.id
     **/
    public function deactivateUser($id)
    {
        $user = $this->repo->deactivate($id);

        return redirect_with_message(
                handles('threef/entree::user'),
                trans('threef/entree::respond.data.deleted', [ 
                    'form' => trans('threef/entree::entree.user.delete'),
                    'person' => title_case(data_get($user,'fullname')) ]),
                'success');
    }


    /**
     * Validate User Status
     *
     * @return void
     * @author 
     **/
    public function validateUserRegistration($control, $request)
    {

        $token = $request->segment(2);
        $email = $request->get('email');

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
            return $control->userEmailValidationRespond('errors');
        endif;

        $user = $this->repo->validateUser($token,$email);

        return view('threef/entree::entree.auth.validation',compact('user'));


    }


    /**
     * Update Account Info
     *
     * @return void
     * @author 
     **/
    public function updateAccountInfo($request)
    {
        $input = $this->delegateUserInfo($request);

        $this->repo->updateUserData($input);

        return redirect_with_message(
                handles('threef/entree::account/info'),
                trans('threef/entree::respond.data.success', [ 'form' => trans('threef/entree::entree.user.edit') ]),
                'success');
    }


} // END class UserManager 
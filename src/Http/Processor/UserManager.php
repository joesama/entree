<?php

namespace Joesama\Entree\Http\Processor;

use Orchestra\Foundation\Processor\User;
use Joesama\Entree\Database\Model\UserProfile as Profile;
use Joesama\Entree\Database\Repository\UserRepo;
use Joesama\Entree\Http\Validation\Profile as Validator;
use Joesama\Entree\Services\DataGrid\VueDatagrid;
use Joesama\Entree\Services\Form\UserProfileForm;
use Joesama\Entree\Services\Upload\FileUploader;
use VueGrid;

/**
 * UserManager class.
 *
 * @author
 **/
class UserManager extends User
{
    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function __construct(UserRepo $repo, Validator $validate)
    {
        $this->repo = $repo;
        $this->validator = $validate;
    }

    /**
     * Listing All User.
     *
     * @return void
     *
     * @author
     **/
    public function userList($request)
    {
        $columns = [
            ['field' => 'fullname', 'title' => trans('joesama/entree::entree.user.grid.fullname'), 'style' => 'text-left'],
            ['field' => 'username', 'title' => trans('joesama/entree::entree.user.grid.username'), 'style' => 'text-left'],
            ['field' => 'email', 'title' => trans('joesama/entree::entree.user.grid.email'), 'style' => 'text-left'],
            ['field' => 'roles:name', 'title' => trans('joesama/entree::entree.user.grid.role'), 'style' => 'text-left multi'],
            ['field' => 'status', 'title' => trans('joesama/entree::entree.user.grid.status'), 'style' => 'text-center'],
            ['field' => 'lastlogin', 'title' => trans('joesama/entree::entree.user.grid.lastlogin'), 'style' => 'text-left date'],
        ];

        $grid = new VueGrid();
        $grid->setColumns($columns);
        $grid->setModel($this->dataList($request));
        $grid->apiUrl(handles('joesama/entree::user/data'));
        $grid->add(handles('joesama/entree::user/new'), trans('joesama/entree::entree.user.action.new'));
        $grid->action([
                ['action' => trans('joesama/entree::datagrid.buttons.edit'),
                  'url'   => handles('joesama/entree::user'),
                  'icons' => 'fa fa-pencil',
                  'key'   => 'id',  ],
                ['action' => trans('joesama/entree::datagrid.buttons.reset-pwd'),
                  'url'   => handles('joesama/entree::user/reset'),
                  'icons' => 'fa fa-key',
                  'key'   => 'id',   ],
                ['delete' => trans('joesama/entree::datagrid.buttons.delete'),
                  'url'   => handles('joesama/entree::user/delete/'),
                  'icons' => 'fa fa-trash',
                  'key'   => 'id',  ],
            ], true);

        return $grid->build();
    }

    /**
     * User Data API.
     *
     * @return void
     *
     * @author
     **/
    public function dataList($request)
    {
        return $this->repo->userList($request);
    }

    /**
     * User Data Form.
     *
     * @return void
     *
     * @author
     **/
    public function userCreation($request)
    {
        $user = $this->repo->userInfo($request->segment(2));
        $roles = $this->repo->userRoleArray();
        $validation = config('joesama/entree::entree.validation');
        $username = config('joesama/entree::entree.username');

        return compact('user', 'roles', 'validation', 'username');
    }

    /**
     * undocumented function.
     *
     * @return void
     *
     * @author
     **/
    public function userInfo($id)
    {
        return $this->repo->userInfo($id);
    }

    /**
     * Process User Update.
     *
     * @return mixed
     **/
    public function userCreate($request)
    {
        $validation = $this->validator->on('create')
            ->with($request->input());

        if ($validation->fails()):

            return redirect_with_message(
                handles('joesama/entree::user/new'),
                trans('joesama/entree::respond.data.failed', ['form' => trans('joesama/entree::entree.user.new')]),
                'danger')
            ->withInput()
            ->withErrors($validation->getMessageBag());

        endif;

        $input = $this->delegateUserInfo($request);
        $user = $this->repo->createUserData($input);

        if (config('joesama/entree::entree.validation')):

            event('joesama.email.user: new', [$user]); else:

            $user->sendWelcomeNotification(data_get($input, 'user.password'));

        endif;

        return redirect_with_message(
                handles('joesama/entree::user'),
                trans('joesama/entree::respond.data.success', ['form' => trans('joesama/entree::entree.user.new')]),
                'success');
    }

    /**
     * External User Registration.
     *
     * @return void
     **/
    public function registerExtNew($request)
    {
        $validation = $this->validator->on('create')
            ->with($request->input());

        if ($validation->fails()):

            return redirect_with_message(
                $request->url(),
                trans('joesama/entree::respond.register.failed', ['form' => trans('joesama/entree::entree.user.new')]),
                'danger')
            ->withInput()
            ->withErrors($validation->getMessageBag());

        endif;

        $input = $this->delegateUserInfo($request);
        $input['user']['roles'] = app(\Joesama\Entree\Database\Model\Role::class)->member()->id;

        $user = $this->repo->createUserData($input);

        if (config('joesama/entree::entree.validation')):

            event('joesama.email.user: new', [$user]); else:

            $user->sendWelcomeNotification(data_get($input, 'user.password'));

        endif;

        return redirect_with_message(
                handles('joesama/entree::/'),
                trans('joesama/entree::respond.register.success', ['form' => trans('joesama/entree::entree.user.new')]),
                'success');
    }

    /**
     * Upload Photo & Update Resources Photo Path.
     *
     * @return void
     *
     * @author
     **/
    public function uploadPhoto($request)
    {
        if ($request->file('photo')->isValid()) :

            $file = new FileUploader($request->file('photo'), $this);

        $this->repo->savePhoto($request, $file->destination());

        return response()->json(['path' => $file->destination()]);

        endif;
    }

    /**
     * Process User Update.
     *
     * @return mixed
     **/
    public function userUpdate($request)
    {
        $validation = $this->validator->on('update')
            ->bind(['userId' => $request->get('id')])
            ->with($request->input());

        if ($validation->fails()):

            return redirect_with_message(
                handles('joesama/entree::user/'.$request->get('id')),
                trans('joesama/entree::respond.data.failed', ['form' => trans('joesama/entree::entree.user.edit')]),
                'danger')
            ->withInput()
            ->withErrors($validation->getMessageBag());

        endif;

        $input = $this->delegateUserInfo($request);

        $user = $this->repo->updateUserData($input);

        return redirect_with_message(
                handles('joesama/entree::user'),
                trans('joesama/entree::respond.data.success', ['form' => trans('joesama/entree::entree.user.edit')]),
                'success');
    }

    /**
     * Delegation of user & profile table.
     *
     * @return array $input
     *
     **/
    protected function delegateUserInfo($request)
    {
        $user = collect([]);
        $profile = collect([]);

        $data = new UserProfileForm($request);

        foreach ($request->except('_token') as $field => $value) {
            if ($value !== ''):
            if (data_get($data, 'profiles')->contains($field)) {
                $profile->put($field, $value);
            } else {
                $user->put($field, $value);
            }
            endif;
        }

        return compact('user', 'profile');
    }

    /**
     * Deactivate User.
     *
     * @param $id users.id
     *
     * @return void
     **/
    public function deactivateUser($id)
    {
        $user = $this->repo->deactivate($id);

        return redirect_with_message(
                handles('joesama/entree::user'),
                trans('joesama/entree::respond.data.deleted', [
                    'form'   => trans('joesama/entree::entree.user.delete'),
                    'person' => title_case(data_get($user, 'fullname')), ]),
                'success');
    }

    /**
     * Validate User Status.
     *
     * @return void
     *
     * @author
     **/
    public function validateUserRegistration($control, $request)
    {
        $token = $request->segment(2);
        $email = $request->get('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
            return $control->userEmailValidationRespond('errors');
        endif;

        $user = $this->repo->validateUser($token, $email);

        return view('joesama/entree::entree.auth.validation', compact('user'));
    }

    /**
     * Update Account Info.
     *
     * @return void
     *
     * @author
     **/
    public function updateAccountInfo($request)
    {
        $input = $this->delegateUserInfo($request);

        $this->repo->updateUserData($input);

        return redirect_with_message(
                handles('joesama/entree::account/info'),
                trans('joesama/entree::respond.data.success', ['form' => trans('joesama/entree::entree.user.edit')]),
                'success');
    }
} // END class UserManager

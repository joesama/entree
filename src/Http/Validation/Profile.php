<?php

namespace Threef\Entree\Http\Validation;

use Orchestra\Support\Validator;
use Illuminate\Validation\Rule;

class Profile extends Validator
{
    /**
     * List of rules.
     *
     * @var array
     */
    protected $rules = [
        'fullname' => ['required'],
        'email' => ['required']
    ];


    /**
     * List of events.
     *
     * @var array
     */
    protected $events = [
        'profile.created'
    ];

    /**
     * On create validations.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['email'][] = 'unique:users';
        $this->rules['idnumber'][] = 'unique:user_profiles';
        $this->phrases['required'] = trans('threef/entree::validation.required');
        $this->phrases['idnumber.unique'] = trans('threef/entree::validation.custom.idnumber.unique');
        $this->phrases['email.unique'] = trans('threef/entree::validation.custom.email.unique');
    }

    // $proxy_host, $proxy_port, $proxy_username, $proxy_password,0,100

    /**
     * On update validations.
     *
     * @return void
     */
    protected function onUpdate()
    {
        $this->rules['idnumber'][] = 'unique:user_profiles,user_id,{userId}';
        $this->rules['email'][] = 'unique:users,id,{userId}';

        $this->phrases['required'] = trans('threef/entree::validation.required');
        $this->phrases['email.unique'] = trans('threef/entree::validation.custom.email.unique');
        $this->phrases['idnumber.unique'] = trans('threef/entree::validation.custom.idnumber.unique');
    }

}

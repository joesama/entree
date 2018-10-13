<?php

namespace Joesama\Entree\Http\Validation;

use Illuminate\Validation\Rule;
use Orchestra\Support\Validator;

class Profile extends Validator
{
    /**
     * List of rules.
     *
     * @var array
     */
    protected $rules = [
        'fullname' => ['required'],
        'email'    => ['required'],
    ];

    /**
     * List of events.
     *
     * @var array
     */
    protected $events = [
        'profile.created',
    ];

    /**
     * On create validations.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['email'][] = Rule::unique('users')->where(function ($query) {
            $query->whereNull('deleted_at');
        });
        $this->rules['idnumber'][] = Rule::unique('user_profiles')->where(function ($query) {
            $query->whereNull('deleted_at');
        });
        $this->phrases['required'] = trans('joesama/entree::validation.required');
        // $this->phrases['idnumber.unique'] = trans('joesama/entree::validation.custom.idnumber.unique');
        $this->phrases['email.unique'] = trans('joesama/entree::validation.custom.email.unique');
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

        $this->phrases['required'] = trans('joesama/entree::validation.required');
        $this->phrases['email.unique'] = trans('joesama/entree::validation.custom.email.unique');
        $this->phrases['idnumber.unique'] = trans('joesama/entree::validation.custom.idnumber.unique');
    }
}

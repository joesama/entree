<?php namespace Threef\Entree\Http\Validation;

use Orchestra\Foundation\Validation\AuthenticateUser;

class User extends AuthenticateUser
{
    /**
     * List of rules.
     *
     * @var array
     */
    protected $rules = [
        // 'email'    => ['required', 'email']
    ];

    /**
     * List of phrases.
     *
     * @var array
     */
    protected $phrases = [
        'exists' => 'Tiada Pengguna Yang Mendaftar Menggunakan Emel Ini.'
    ];

    /**
     * List of events.
     *
     * @var array
     */
    protected $events = [
        'orchestra.validate: users',
        'orchestra.validate: user.account',
    ];

    /**
     * On reset user scenario.
     *
     * @return void
     */
    protected function onReset()
    {
        $this->rules = [
            'email'   => ['required','exists:users']
        ];

    }

    /**
     * On create user scenario.
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['password'] = ['required'];
    }

    /**
     * On login scenario.
     *
     * @return void
     */
    protected function onLogin()
    {
        $this->rules['username'] = ['required'];
        $this->rules['password'] = ['required'];
    }
}

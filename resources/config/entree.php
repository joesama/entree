<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Setup Username field
    |--------------------------------------------------------------------------
    |
    | This value is the name of the field that will be use as username.
    | By default will be email.
    |
    | Available Settings: "email", "username".
    |
    */

    'username' => env('USER_NAME', 'email'),

    /*
    |--------------------------------------------------------------------------
    | Config Register User Method
    |--------------------------------------------------------------------------
    |
    | To set process use to register user either required email validation or not
    |
    */

    'validation' => env('USER_VALIDATION', false),

    /*
    |--------------------------------------------------------------------------
    | Reroute Landing Page
    |--------------------------------------------------------------------------
    |
    | To set process use to register user either required email validation or not
    |
    */

    'landing' => env('LANDING_PAGE', 'home'),

];

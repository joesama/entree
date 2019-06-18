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
    | Config Ldap Authentication
    |--------------------------------------------------------------------------
    |
    | To use LDAP Authentication
    | 
    */

    'ldap' => env('LDAP_AUTH', FALSE),
    'accoount' => [
        'suffix' => env('ADLDAP_ACCOUNT_SUFFIX'),
        'domains' => env('ADLDAP_CONTROLLERS','ldap'),
        'dn' => env('ADLDAP_BASEDN'),
        'admn_user' => env('ADLDAP_ADMIN_USERNAME'),
        'admn_pword' => env('ADLDAP_ADMIN_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Define Email Account
    |--------------------------------------------------------------------------
    |
    | Definition Of Email Used To Send Email
    | 
    */

    'mail_account' => env('MAIL_ACCOUNT',FALSE),

    /*
    |--------------------------------------------------------------------------
    | Renew Email Account Password
    |--------------------------------------------------------------------------
    |
    | If Email Password Should be renewed
    | 
    */

    'mail_renew' => env('MAIL_RENEWAL',FALSE),

    /*
    |--------------------------------------------------------------------------
    | Renew Email Account Password Receipient
    |--------------------------------------------------------------------------
    |
    | If Email Password Should be renewed
    | 
    */

    'mail_owner' => env('MAIL_OWNER'),

    /*
    |--------------------------------------------------------------------------
    | Reroute Landing Page
    |--------------------------------------------------------------------------
    |
    | To set process use to register user either required email validation or not
    |
    */

    'landing' => env('LANDING_PAGE', 'home'),

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | To set process use to register user either required email validation or not
    |
    */

    'language' => env('SPEAK', 'ms'),

];

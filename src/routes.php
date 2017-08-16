<?php
use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

Foundation::group('threef/entree', NULL , ['namespace' => 'Http\Controller', 'middleware' => ['web']], function (Router $router) {

	$router->group(['middleware' => 'guest'],function($router){
		$router->get('/', 'Entrance@getIndex');
		$router->get('/login', 'Entrance@getIndex');
		$router->post('/login', 'Auth\Access@login');
		$router->get('/validate/{token}', 'Auth\Access@emailValidation');
		$router->get('/forgot', 'Auth\ResetPassword@getSelfReset');
		$router->post('/forgot', 'Auth\ResetPassword@postSelfReset');
		$router->get('/forgot/reset/{token}', 'Auth\ResetPassword@getResetPassword');
		$router->post('/forgot/reset/{token}', 'Auth\ResetPassword@postResetPassword');
	});

	$router->group(['middleware' => 'auth'],function($router){
		$router->get('/home', 'Auth\Access@home');
		$router->get('/logout', 'Auth\Access@logout');
		$router->get('/password', 'Auth\Password@edit');
		$router->post('/password', 'Auth\Password@update');

		// Base Configuration
		$router->get('/base', 'Admin\BasicSetup@appConfig');
		$router->post('/base', 'Admin\BasicSetup@saveAppConfig');
		$router->post('/logo', 'Admin\BasicSetup@saveLogo');
		$router->post('/favicon', 'Admin\BasicSetup@saveFavicon');

		$router->get('/menu', 'MenuAccess@getIndex');
		$router->post('/menu', 'MenuAccess@menuAccess');

		$router->group(['prefix' => 'user'],function($router){
			$router->get('/', 'User@getIndex');
			$router->get('/data', 'User@dataApi');
			$router->get('/{id}', 'User@getUserUpdate')->where(['id' => '[0-9]+']);
			$router->get('/new', 'User@getUserCreation');
			$router->post('/new', 'User@postUserCreation');
			$router->post('/{id}', 'User@postUserUpdate')->where(['id' => '[0-9]+']);
			$router->post('/photo', 'User@savePhoto');
			$router->get('/delete/{id}', 'User@getRemoveUser')->where(['id' => '[0-9]+']);
			$router->get('/reset/{id}', 'Auth\ResetPassword@adminResetPassword')
			->where(['id' => '[0-9]+']);
		});
		
		$router->get('/account/info', 'Account\UserInfo@getIndex');
		$router->post('/account/info', 'Account\UserInfo@saveInfo');

		$router->group(['prefix' => 'report', 'namespace' => 'Report'],function($router){
			$router->get('/list', 'Reporter@getIndex');
			$router->get('/category', 'ReporterGroup@getIndex');
			$router->get('/access', 'ReporterAccess@getIndex');
		});
	});

 });



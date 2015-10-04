<?php

Route::group(['namespace' => 'Threef\Entree\Http\Controller'], function($router)
{
	$router->group(['middleware' => 'guest'],function($router){
		$router->get('/', 'Entrance@getIndex');
		$router->get('/login', 'Entrance@getIndex');
		$router->post('/login', 'Auth\Access@login');
	});

	$router->get('/forgot', 'Auth\ResetPassword@getSelfReset');
	$router->post('/forgot', 'Auth\ResetPassword@postSelfReset');
	$router->get('/forgot/reset/{token}', 'Auth\ResetPassword@getResetPassword');
	$router->post('/forgot/reset/{token}', 'Auth\ResetPassword@postResetPassword');

	$router->group(['middleware' => 'auth.basic'],function($router){
		$router->get('/home', 'Auth\Access@home');
		$router->get('/logout', 'Auth\Access@logout');
		$router->get('/password', 'Auth\Password@edit');
		$router->post('/password', 'Auth\Password@update');
		$router->get('/user', 'User@getIndex');
		$router->get('/userdata', 'User@getUsers');
		$router->get('/user/reset/{id}', 'Auth\ResetPassword@adminResetPassword')->where(['id' => '[0-9]+']);
	});
});
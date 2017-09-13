<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function($router) 
{
	$router->POST('/auth/login', 'AuthController@login');
	$router->group(['middleware' => 'auth:api'], function($router)
	{
	    $router->GET('/auth/user', 'AuthController@authenticateUser');
	    $router->GET('/auth/invalidate', 'AuthController@invalidateToken');
	    $router->GET('/auth/refresh', 'AuthController@refreshToken');
	    $router->POST('/users/add', 'UserController@createUser');
	    $router->DELETE('/users/{id}/delete', 'UserController@deleteUser');
	    $router->GET('/users/{id}/view', 'UserController@getUser');
	});
});

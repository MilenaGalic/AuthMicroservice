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
		$router->group(['prefix' => 'auth'], function($router) 
		{
			$router->GET('/user', 'AuthController@authenticateUser');
		    $router->GET('/invalidate', 'AuthController@invalidateToken');
		    $router->GET('/refresh', 'AuthController@refreshToken');
		});
	    $router->group(['prefix' => 'users'], function($router) 
		{ 
			$router->POST('/add', 'UserController@createUser');
		    $router->DELETE('/{id}/delete', 'UserController@deleteUser');
		    $router->GET('/{id}/view', 'UserController@getUser');
		    $router->GET('/index', 'UserController@getUsers');
		});
	   	$router->group(['prefix' => 'blacklists'], function($router) 
		{  
			$router->group(['prefix' => 'tokens'], function($router) 
			{  
				$router->GET('/', 'AuthController@getTokenBlacklist');
	    		$router->GET('/{jti}/check', 'AuthController@isTokenBlacklisted');
	    		$router->POST('/{jti}/add', 'AuthController@createTokenBlacklistEntry');
			});
		});
	   
	});
});

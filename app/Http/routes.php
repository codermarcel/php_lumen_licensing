<?php

use App\Service\Api\Api;
use Illuminate\Support\Facades\Cache;

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

$app->get('/', function () use ($app) {
	return (new Api())
		->set('Api Version', '0.1.0')
		->set('Last changes', '20.04.2016')
		->set('News', 'N/A')
		->build();
});

$app->group(['prefix' =>'auth', 'middleware' => ['throttle_ip:20,1'], 'namespace' => 'App\Http\Controllers'], function () use($app){
	$app->post('/register',    'AuthController@register');
	$app->post('/recover',    'AuthController@recover'); //request the recover token
	$app->post('/update',    'AuthController@update');   //do the recover
	$app->post('/apikey',      'AuthController@authenticateKeyInput');
	$app->post('/credentials', 'AuthController@authenticateCredentials');
	$app->post('/refresh-jwt', 'AuthController@refreshJwt');
});

$app->group(['prefix' =>'user', 'middleware' => ['auth', 'limiter'], 'namespace' => 'App\Http\Controllers'], function () use ($app) {
	$app->get('/',        'UserController@index');
	$app->get('/show',    'UserController@show');
	$app->post('/create', 'UserController@create');
	$app->post('/update', 'UserController@update');
	$app->post('/delete', 'UserController@delete');
});

$app->group(['prefix' =>'product', 'middleware' => ['auth'], 'namespace' => 'App\Http\Controllers'], function () use ($app) {
	$app->get('/', 	   	  'ProductController@index');
	$app->get('/show',    'ProductController@show');
	$app->post('/create', 'ProductController@create');
	$app->post('/update', 'ProductController@update');
	$app->post('/delete', 'ProductController@delete');
});

$app->group(['prefix' =>'ban', 'middleware' => ['throttle_point:50,1', 'auth'], 'namespace' => 'App\Http\Controllers'], function () use ($app) {
	$app->get('/', 	      'BanController@index');
	$app->get('/show',    'BanController@show');
	$app->post('/create', 'BanController@create');
	$app->post('/update', 'BanController@update');
	$app->post('/delete', 'BanController@delete');
});

$app->group(['prefix' =>'group', 'middleware' => ['throttle_point:50,1', 'auth'], 'namespace' => 'App\Http\Controllers'], function () use ($app) {
	$app->get('/', 	      'GroupController@index');
	$app->get('/show',    'GroupController@show');
	$app->post('/create', 'GroupController@create');
	$app->post('/update', 'GroupController@update');
	$app->post('/delete', 'GroupController@delete');
});



$app->group(['prefix' =>'permission', 'middleware' => ['throttle_point:50,1', 'auth'], 'namespace' => 'App\Http\Controllers'], function () use ($app) {
	$app->get('/', 	      'PermissionController@index');
});



$app->group(['prefix' =>'code', 'middleware' => ['throttle_point:50,1', 'auth'], 'namespace' => 'App\Http\Controllers'], function () use ($app) {
	$app->get('/', 	      'CodeController@index');
	$app->get('/show',    'CodeController@show');
	$app->post('/create', 'CodeController@create');
	$app->post('/update', 'CodeController@update');
	$app->post('/delete', 'CodeController@delete');
});
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth', 'prefix' => '/'], function() {
	Route::get('/', [
		'as' => 'index',
		'uses' => 'HomeController@index'
	]);

	Route::get('/nhan-qua', [
		'as' => 'gift.index',
		'uses' => 'GiftController@index'
	]);
	Route::post('/nhan-qua/', [
		'as' => 'gift.store',
		'uses' => 'GiftController@store'
	]);
});

Route::auth();

Route::get('api', [
	'as' => 'home.api',
	'uses' => 'HomeController@api'
]);
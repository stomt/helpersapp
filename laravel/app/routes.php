<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => 'cities/{city_id}'), function() {

	Route::group(array('prefix' => 'insertions/{request_id}'), function() {

		Route::resource('help', 'HelpController', array('only' => array('store')));

	});

	Route::resource('insertions', 'InsertionsController', array('only' => array('index', 'store', 'update', 'destroy')));

});

Route::resource('cities', 'CitiesController', array('only' => array('index', 'store')));


Route::get('cities/myhelp', 'InsertionsController@myhelp');
Route::get('/', 'HomeController@index');

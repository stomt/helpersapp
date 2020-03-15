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

$router->get('cities/{city_id}/insertions', 'App\Http\Controllers\InsertionsController@index');
$router->post('cities/{city_id}/insertions', 'App\Http\Controllers\InsertionsController@store');
$router->post('cities/{city_id}/insertions/{insertion_id}/help', 'App\Http\Controllers\HelpController@store');
$router->put('cities/{city_id}/insertions/{insertion_id}', 'App\Http\Controllers\InsertionsController@update');
$router->delete('cities/{city_id}/insertions/{insertion_id}', 'App\Http\Controllers\InsertionsController@destroy');

$router->get('cities', 'App\Http\Controllers\CitiesController@index');
$router->post('cities', 'App\Http\Controllers\CitiesController@store');

$router->get('cities/myhelp', 'App\Http\Controllers\InsertionsController@myhelp');
$router->get('/', 'App\Http\Controllers\HomeController@index');

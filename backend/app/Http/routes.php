<?php

$app->get('cities/{city_id}/insertions', 'App\Http\Controllers\InsertionsController@index');
$app->post('cities/{city_id}/insertions', 'App\Http\Controllers\InsertionsController@store');
$app->post('cities/{city_id}/insertions/{insertion_id}', 'App\Http\Controllers\HelpController@store');
$app->put('cities/{city_id}/insertions/{insertion_id}', 'App\Http\Controllers\InsertionsController@update');
$app->delete('cities/{city_id}/insertions/{insertion_id}', 'App\Http\Controllers\InsertionsController@destroy');

$app->get('cities', 'App\Http\Controllers\CitiesController@index');
$app->post('cities', 'App\Http\Controllers\CitiesController@store');

$app->get('cities/myhelp', 'App\Http\Controllers\InsertionsController@myhelp');
$app->get('/', 'App\Http\Controllers\HomeController@index');

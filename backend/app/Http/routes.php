<?php


$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'cities/{city_id}'], function($app) {

    $app->group(['prefix' => 'insertions/{request_id}'], function($app) {

        $app->post('help', 'App\Http\Controllers\HelpController@store');

    });

    $app->get('insertions', 'App\Http\Controllers\InsertionsController@index');
    $app->post('insertions', 'App\Http\Controllers\InsertionsController@store');
    $app->put('insertions', 'App\Http\Controllers\InsertionsController@update');
    $app->delete('insertions', 'App\Http\Controllers\InsertionsController@destroy');

});

$app->get('cities', 'App\Http\Controllers\CitiesController@index');
$app->post('cities', 'App\Http\Controllers\CitiesController@store');

$app->get('cities/myhelp', 'App\Http\Controllers\InsertionsController@myhelp');
$app->get('/', 'App\Http\Controllers\HomeController@index');

<?php


$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'cities/{city_id}'], function($app) {

    $app->group(['prefix' => 'insertions/{request_id}'], function($app) {

        $app->post('help', 'HelpController@store');

    });

    $app->get('insertions', 'InsertionsController@index');
    $app->post('insertions', 'InsertionsController@store');
    $app->put('insertions', 'InsertionsController@update');
    $app->delete('insertions', 'InsertionsController@destroy');

});

$app->get('cities', 'CitiesController@index');
$app->post('cities', 'CitiesController@store');

$app->get('cities/myhelp', 'InsertionsController@myhelp');
$app->get('/', 'HomeController@index');

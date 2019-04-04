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
    return 'Welcome to Modus Test API';
});

$router->group(['prefix' => 'vehicles'], function () use ($router){
    $router->get('/{year}/{manufacturer}/{model}', 'VehicleController@getVehicles');
    $router->post('/', 'VehicleController@getVehicles');
});

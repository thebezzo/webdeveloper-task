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
    return view('welcome');
    return $router->app->version();
});

$router->group(['prefix' => 'api/items', 'middleware' => 'item'], function () use ($router) {
    $router->get('/', 'ItemController@showPage');
    $router->get('/{pageNum}', 'ItemController@showPage');
});

<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['prefix' => ''], function () use ($router) {
    // User Auth
    $router->post('login','UserController@login');
    $router->post('loginUsingFB', ['uses' => 'UserController@loginUsingFB']);
    $router->post('register', 'UserController@register');
});

$router->group(['prefix' => 'api'], function () use ($router){

    // USER ROUTES
    $router->get('users', ['uses' => 'UserController@show']);


    // VCPLAYER ROUTES
    $router->get('players', ['uses' => 'PlayerController@show']);
    $router->get('player/search', ['uses' => 'PlayerController@showByName']);
    $router->get('player/products', ['uses' => 'PlayerController@showPlayerProducts']);


    // PRODUCT ROUTES
    $router->get('products', ['uses' => 'ProductController@show']);
    $router->get('product/search', ['uses' => 'ProductController@showByName']);
});

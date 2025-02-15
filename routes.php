<?php


$router->get('/', 'HomeController@index');
$router->get('/profile', 'HomeController@profile', ['auth']);
$router->get('/game/options', 'GameController@create', ['auth']);

$router->post('/game/{token}', 'GameController@start', ['auth']);



$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);



$router->post('/auth/register', 'UserController@store', ['guest']);
$router->post('/auth/login', 'UserController@authenticate', ['guest']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);




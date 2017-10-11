<?php

$app['router']->get('/', 'HomeController@index');
$app['router']->get('/test', 'HomeController@test');

$app['router']->get('/user', 'UserController@index');
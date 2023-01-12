<?php

require __DIR__ . '/vendor/autoload.php';

$app = new \Bramus\Router\Router();
$app->setNamespace('Mamad\CurrencyApp');

$app->get('/', 'HomeController@index');
$app->get('/home', 'HomeController@home');
$app->get('/signup', 'RegistrationController@index');
$app->post('/signup', 'RegistrationController@create');
$app->get('/login', 'RegistrationController@loginIndex');
$app->post('/login', 'RegistrationController@login');
$app->get('/logout', 'RegistrationController@logout');


$app->run();
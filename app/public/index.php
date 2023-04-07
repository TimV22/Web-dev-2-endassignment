<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// login route
$router->post('/api/login', 'UserController@login');

// register route
$router->post('/api/register', 'UserController@register');

// score routes
const API_SCORE = '/api/score';
$router->get(API_SCORE, 'ScoreController@getScore');
$router->post(API_SCORE, 'ScoreController@create');
$router->put(API_SCORE, 'ScoreController@update');
$router->delete(API_SCORE, 'ScoreController@delete');

$router->put('/api/score/add/(\d+)', 'ScoreController@addBetToScore');
$router->put('/api/score/subtract/(\d+)', 'ScoreController@removeBetFromScore');

$router->run();

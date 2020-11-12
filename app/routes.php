<?php
declare(strict_types=1);

use Todo\Controllers\AuthController;
use Todo\Controllers\TaskController;

$container->set('router', \DI\value($app->getRouteCollector()->getRouteParser()));

$app->get('/', TaskController::class.':getHome')->setName('home');

$app->get('/login', AuthController::class.':getLogin')->setName('login');
$app->post('/login', AuthController::class.':postLogin');

$app->get('/logout', AuthController::class.':logout');

$app->get('/signup', AuthController::class.':getSignup')->setName('signup');
$app->post('/signup', AuthController::class.':postSignup');

$app->post('/task', TaskController::class.':postTask');

$app->get('/search', TaskController::class.':getSearch');

$app->post('/add', TaskController::class.':postAdd');
$app->post('/create', TaskController::class.':postCreate');

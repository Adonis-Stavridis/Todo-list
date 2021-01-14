<?php

declare(strict_types=1);

use Slim\Interfaces\RouteParserInterface;
use Todo\Features\Comment\CommentController;
use Todo\Features\CreateTask\CreateTaskController;
use Todo\Features\Login\LoginController;
use Todo\Features\Logout\LogoutController;
use Todo\Features\RenderHomePage\RenderHomePageController;
use Todo\Features\RenderLoginPage\RenderLoginPageController;
use Todo\Features\RenderSignupPage\RenderSignupPageController;
use Todo\Features\RenderTaskPage\RenderTaskPageController;
use Todo\Features\Signup\SignupController;

use function DI\value;

/**
 * Set a RouteParserInterface::class field inside the container.
 */
$container->set(
	RouteParserInterface::class,
	value($app->getRouteCollector()->getRouteParser())
);

/**
 * Create all routes for the app.
 */
$app->get('/', RenderHomePageController::class)->setName('home');

$app->get('/login', RenderLoginPageController::class)->setName('login');
$app->post('/login', LoginController::class);

$app->get('/logout', LogoutController::class)->setName('logout');

$app->get('/signup', RenderSignupPageController::class)->setName('signup');
$app->post('/signup', SignupController::class);

$app->get('/task-{taskId:[1-9][0-9]*}', RenderTaskPageController::class)->setName('task');

$app->post('/create', CreateTaskController::class);

$app->post('/comment', CommentController::class);

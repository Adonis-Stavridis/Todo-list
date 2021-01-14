<?php

declare(strict_types=1);

use TodoDomain\Endpoints\Information\InformationController;
use TodoDomain\GetAllUsers\GetAllUsersController;

/**
 * Create all routes for the app.
 */
$app->get('/', InformationController::class);

$app->get('/users', GetAllUsersController::class);
// $app->post('/users', CreateUserController::class);

// $app->get('/users/{username:[a-zA-Z0-9]*}', GetAllUsersController::class);

// $app->get('/logout', LogoutController::class)->setName('logout');

// $app->get('/signup', RenderSignupPageController::class)->setName('signup');
// $app->post('/signup', SignupController::class);

// $app->get('/task-{taskId:[1-9][0-9]*}', RenderTaskPageController::class)->setName('task');

// $app->post('/create', CreateTaskController::class);

// $app->post('/comment', CommentController::class);

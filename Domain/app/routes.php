<?php

declare(strict_types=1);

use TodoDomain\Endpoints\Information\InformationController;
use TodoDomain\Endpoints\Tasks\TasksController;

/**
 * Create all routes for the app.
 */
$app->get('/', InformationController::class);

$app->get('/tasks', TasksController::class);

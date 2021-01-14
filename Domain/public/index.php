<?php

declare(strict_types=1);

session_start();

use TodoDomain\TodoApp;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Create App and run it.
 */
$app = new TodoApp();

$app->run();

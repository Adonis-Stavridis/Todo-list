<?php
declare(strict_types=1);
session_start();

use Todo\TodoApp;

require __DIR__ . '/../vendor/autoload.php';

$app = new TodoApp();

$app->run();

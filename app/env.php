<?php
declare(strict_types=1);

use Dotenv\Dotenv;

/**
 * Loads the $_ENV variable with the contents of .env file.
 */
$dotenv = DotEnv::createImmutable(__DIR__ . '/../');
$dotenv->load();

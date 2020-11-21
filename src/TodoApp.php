<?php
declare(strict_types=1);

namespace Todo;

use Slim\App;
use Slim\Factory\AppFactory;

class TodoApp {
  private App $app;

  public function __construct() {
    require __DIR__ . '/../app/env.php';

    $dependencies = require __DIR__ . '/../app/dependencies.php';
    $container = $dependencies();

    $settings = require __DIR__ . '/../app/settings.php';
    $settings($container);

    AppFactory::setContainer($container);

    $app = AppFactory::create();

    $middleware = require __DIR__ . '/../app/middleware.php';
    $middleware($app);

    require __DIR__ . '/../app/routes.php';

    $this->app = $app;
  }

  public function get(): App {
    return $this->app;
  }

  public function run(): void {
    $this->app->run();
  }
}

<?php

declare(strict_types=1);

namespace TodoWeb;

use Slim\App;
use Slim\Factory\AppFactory;

class TodoApp
{
	/**
	 * @var App $app
	 */
	private App $app;

	/**
	 * Constructor function
	 * 
	 * @return static
	 */
	public function __construct()
	{
		require __DIR__ . '/../app/env.php';

		$dependencies = require __DIR__ . '/../app/dependencies.php';
		$container = $dependencies();

		AppFactory::setContainer($container);

		$app = AppFactory::create();

		$middleware = require __DIR__ . '/../app/middleware.php';
		$middleware($app);

		require __DIR__ . '/../app/routes.php';

		$this->app = $app;
	}

	/**
	 * App getter
	 * 
	 * @return App
	 */
	public function get(): App
	{
		return $this->app;
	}

	/**
	 * Run App
	 * 
	 * @return void
	 */
	public function run(): void
	{
		$this->app->run();
	}
}

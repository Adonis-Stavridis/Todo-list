<?php

declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Slim\Views\Twig;
use TodoWeb\Repositories\Api\ApiTaskRepository;
use TodoWeb\Repositories\Api\ApiUserRepository;
use TodoWeb\Repositories\TaskRepository;
use TodoWeb\Repositories\UserRepository;

/**
 * Builds a container with all dependencies.
 *
 * Set a 'db' field inside the container to access a PDO instance to connect to
 * a database. Sets a 'view' field to access Twig views. Returns the built 
 * container.
 *
 * @return Container
 */
return function (): Container {
	$containerBuilder = new ContainerBuilder();

	$containerBuilder->addDefinitions([
		Twig::class => function (): Twig {
			$path = $_ENV['VIEWS_PATH'];
			$view = Twig::create(__DIR__ . $path, ["cache" => false]);
			return $view;
		},
		UserRepository::class => function (): UserRepository {
			return new ApiUserRepository(
				Psr18ClientDiscovery::find(),
				Psr17FactoryDiscovery::findRequestFactory(),
				Psr17FactoryDiscovery::findStreamFactory(),
				$_ENV['API_URL']
			);
		},
		TaskRepository::class => function (): TaskRepository {
			return new ApiTaskRepository(
				Psr18ClientDiscovery::find(),
				Psr17FactoryDiscovery::findRequestFactory(),
				Psr17FactoryDiscovery::findStreamFactory(),
				$_ENV['API_URL']
			);
		}
	]);

	return $containerBuilder->build();
};

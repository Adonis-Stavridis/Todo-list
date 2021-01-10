<?php

declare(strict_types=1);

namespace Todo\Features\Logout;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;

class LogoutController
{
	private RouteParserInterface $router;

	public function __construct(RouteParserInterface $router)
	{
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		session_unset();
		$response->withStatus(200);
		return $response->withHeader('Location', $this->router->urlFor('login'));
	}
}

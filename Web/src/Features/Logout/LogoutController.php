<?php

declare(strict_types=1);

namespace TodoWeb\Features\Logout;

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
		return $response->withHeader('Location', $this->router->urlFor('login'))->withStatus(200);
	}
}

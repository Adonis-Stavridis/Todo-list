<?php

declare(strict_types=1);

namespace TodoWeb\Features\Logout;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;

class LogoutController
{
	/**
	 * @var RouteParserInterface $router
	 */
	private RouteParserInterface $router;

	/**
	 * Constructor function
	 * 
	 * @param RouteParserInterface $router
	 * 
	 * @return static
	 */
	public function __construct(RouteParserInterface $router)
	{
		$this->router = $router;
	}

	/**
	 * Invoke function handle request and send response
	 * 
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * 
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		session_unset();
		return $response->withHeader('Location', $this->router->urlFor('login'))->withStatus(200);
	}
}

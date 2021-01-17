<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class LoginController
{
	/**
	 * @var LoginService $service
	 */
	private LoginService $service;

	/**
	 * @var Twig $view
	 */
	private Twig $view;

	/**
	 * @var RouteParserInterface $router
	 */
	private RouteParserInterface $router;

	/**
	 * Constructor function
	 * 
	 * @var LoginService $service
	 * @var Twig $view
	 * @var RouteParserInterface $router
	 * 
	 * @return static
	 */
	public function __construct(LoginService $service, Twig $view, RouteParserInterface $router)
	{
		$this->service = $service;
		$this->view = $view;
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
		try {
			$body = json_decode(json_encode($request->getParsedBody()));
			$businessRequest = LoginRequest::from($body);
			$businessResponse = $this->service->handle($businessRequest);

			$_SESSION['user'] = serialize($businessResponse->getUser());

			return $response->withHeader('Location', $this->router->urlFor('home'))->withStatus(200);
		} catch (Exception $exception) {
			return $this->view->render($response, "/page/login.twig", ['message' => $exception->getMessage()])->withStatus($exception->getCode());
		}
	}
}

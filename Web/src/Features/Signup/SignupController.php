<?php

declare(strict_types=1);

namespace TodoWeb\Features\Signup;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class SignupController
{
	/**
	 * @var SignupService $service
	 */
	private SignupService $service;

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
	 * @var SignupService $service
	 * @var Twig $view
	 * @var RouteParserInterface $router
	 * 
	 * @return static
	 */
	public function __construct(SignupService $service, Twig $view, RouteParserInterface $router)
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
			$businessRequest = SignupRequest::from($body);
			$this->service->handle($businessRequest);

			return $response->withHeader('Location', $this->router->urlFor('login'))->withStatus(200);
		} catch (Exception $exception) {
			return $this->view->render($response, "/page/signup.twig", ['message' => $exception->getMessage()])->withStatus($exception->getCode());
		}
	}
}

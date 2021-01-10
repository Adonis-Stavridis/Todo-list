<?php

declare(strict_types=1);

namespace Todo\Features\Signup;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class SignupController
{
	private SignupService $service;
	private Twig $view;
	private RouteParserInterface $router;

	public function __construct(SignupService $service, Twig $view, RouteParserInterface $router)
	{
		$this->service = $service;
		$this->view = $view;
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		try {
			$body = json_decode(json_encode($request->getParsedBody()));
			$businessRequest = SignupRequest::from($body);
			$this->service->handle($businessRequest);

			$response->withStatus(200);
			return $response->withHeader('Location', $this->router->urlFor('login'));
		} catch (Exception $exception) {
			$response->withStatus($exception->getCode());
			return $this->view->render($response, "/page/signup.twig", ['message' => $exception->getMessage()]);
		}
	}
}
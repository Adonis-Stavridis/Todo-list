<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\CreateUser;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateUserController
{
	private CreateUserService $service;

	public function __construct(CreateUserService $service)
	{
		$this->service = $service;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		try {
			$body = json_decode($request->getParsedBody());
			$businessRequest = CreateUserRequest::from($body);
			$this->service->handle($businessRequest);

			$response->withStatus(200);
			return $response;
		} catch (Exception $exception) {
			$response->withStatus($exception->getCode());
			$response->getBody()->write($exception->getMessage());
			return $response;
		}
	}
}

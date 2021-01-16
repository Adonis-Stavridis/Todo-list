<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\GetAllUsers;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllUsersController
{
	private GetAllUsersService $service;

	public function __construct(GetAllUsersService $service)
	{
		$this->service = $service;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		try {
			$users = $this->service->handle();
			$jsonResponse = json_encode($users);
			$response->getBody()->write($jsonResponse);
			return $response;
		} catch (Exception $exception) {
			$response->getBody()->write($exception->getMessage());
			return $response->withStatus($exception->getCode());
		}
	}
}

<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\Tasks;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TasksController
{
	private TasksService $service;

	public function __construct(TasksService $service)
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

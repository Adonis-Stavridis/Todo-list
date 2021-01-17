<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\Tasks;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TasksController
{
	/**
	 * @var TasksService $service
	 */
	private TasksService $service;

	/**
	 * Constructor function
	 * 
	 * @param TasksService $service
	 * 
	 * @return static
	 */
	public function __construct(TasksService $service)
	{
		$this->service = $service;
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

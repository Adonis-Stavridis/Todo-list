<?php

declare(strict_types=1);

namespace TodoWeb\Features\CreateTask;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class CreateTaskController
{
	private CreateTaskService $service;
	private Twig $view;
	private RouteParserInterface $router;

	public function __construct(CreateTaskService $service, Twig $view, RouteParserInterface $router)
	{
		$this->service = $service;
		$this->view = $view;
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		try {
			$body = json_decode(json_encode($request->getParsedBody()));
			$businessRequest = CreateTaskRequest::from($body);
			$businessResponse = $this->service->handle($businessRequest);

			return $response->withHeader('Location', $this->router->urlFor('task', ['taskId' => $businessResponse->getTaskId()]))->withStatus(200);
		} catch (Exception $exception) {
			$sessionUser = unserialize($_SESSION['user']);
			$sessionUsers = unserialize($_SESSION['users']);
			$sessionTasks = $_SESSION['tasks'];

			return $this->view->render($response, "/page/home.twig", [
				'user' => $sessionUser,
				'users' => $sessionUsers,
				'tasks' => $sessionTasks,
				'message' => $exception->getMessage()
			])->withStatus($exception->getCode());
		}
	}
}

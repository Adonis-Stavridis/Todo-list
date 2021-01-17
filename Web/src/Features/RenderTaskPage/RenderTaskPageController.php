<?php

declare(strict_types=1);

namespace TodoWeb\Features\RenderTaskPage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use TodoWeb\Repositories\ApiRepository;
use TodoWeb\Repositories\TaskRepository;

class RenderTaskPageController
{
	private TaskRepository $repository;
	private ApiRepository $apiRepository;
	private Twig $view;
	private RouteParserInterface $router;

	public function __construct(TaskRepository $repository, ApiRepository $apiRepository, Twig $view, RouteParserInterface $router)
	{
		$this->repository = $repository;
		$this->apiRepository = $apiRepository;
		$this->view = $view;
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		if (!$_SESSION['user']) {
			return $response->withHeader('Location', $this->router->urlFor('login'))->withStatus(200);
		}

		$_SESSION['tasks'] = $this->apiRepository->getAll();

		$sessionUser = unserialize($_SESSION['user']);
		$sessionUsers = unserialize($_SESSION['users']);
		$sessionTasks = $_SESSION['tasks'];

		$task = $this->repository->getTask((int)$args['taskId']);
		$comments = $this->repository->getTaskComments($task->getId());

		return $this->view->render($response, "/page/task.twig", [
			'user' => $sessionUser,
			'users' => $sessionUsers,
			'tasks' => $sessionTasks,
			'task' => $task,
			'comments' => $comments
		])->withStatus(200);
	}
}

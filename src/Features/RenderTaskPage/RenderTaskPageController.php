<?php
declare(strict_types=1);

namespace Todo\Features\RenderTaskPage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use Todo\Repositories\TaskRepository;

class RenderTaskPageController {
  private TaskRepository $repository;
  private Twig $view;
  private RouteParserInterface $router;

  public function __construct(TaskRepository $repository, Twig $view, RouteParserInterface $router) {
    $this->repository = $repository;
    $this->view = $view;
    $this->router = $router;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
    if (!$_SESSION['user']) {
      $response->withStatus(200);
      return $response->withHeader('Location', $this->router->urlFor('login'));
		}

		$_SESSION['tasks'] = $this->repository->getAll();

    $sessionUser = unserialize($_SESSION['user']);
    $sessionUsers = unserialize($_SESSION['users']);
    $sessionTasks = $_SESSION['tasks'];

    $task = $this->repository->getTask((int)$args['taskId']);

    $response->withStatus(200);
    return $this->view->render($response, "/page/task.twig", [
      'user' => $sessionUser,
      'users' => $sessionUsers,
      'tasks' => $sessionTasks,
      'task' => $task
    ]);
  }
}

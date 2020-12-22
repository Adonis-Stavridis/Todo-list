<?php
declare(strict_types=1);

namespace Todo\Features\RenderHomePage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use Todo\Repositories\TaskRepository;
use Todo\Repositories\UserRepository;

class RenderHomePageController {
  private UserRepository $userRepository;
  private TaskRepository $taskRepository;
  private Twig $view;
  private RouteParserInterface $router;

  public function __construct(UserRepository $userRepository, TaskRepository $taskRepository, Twig $view, RouteParserInterface $router) {
    $this->userRepository = $userRepository;
    $this->taskRepository = $taskRepository;
    $this->view = $view;
    $this->router = $router;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    if (!$_SESSION['user']) {
      $response->withStatus(200);
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }

    if (!$_SESSION['users']) {
      $_SESSION['users'] = serialize($this->userRepository->getAll());
    }

    if (!$_SESSION['tasks']) {
      $_SESSION['tasks'] = $this->taskRepository->getAll();
    }

    $sessionUser = unserialize($_SESSION['user']);
    $sessionUsers = unserialize($_SESSION['users']);
    $sessionTasks = $_SESSION['tasks'];
    
    $response->withStatus(200);
    return $this->view->render($response, "/page/home.twig", [
      'user' => $sessionUser,
      'users' => $sessionUsers,
      'tasks' => $sessionTasks
    ]);
  }
}

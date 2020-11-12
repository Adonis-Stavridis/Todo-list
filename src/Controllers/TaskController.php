<?php
declare(strict_types=1);

namespace Todo\Controllers;

use Todo\Models\Task;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TaskController extends Task
{
  # HOME
  public function getHome(Request $request, Response $response, array $args): Response {
    if (!$_SESSION['user']) {
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }

    $_SESSION['tasks'] = $this->getAllTasks();
    
    return $this->view->render($response, "/page/home.twig", ['username' => $_SESSION['user']['username'], 'tasks' => $_SESSION['tasks']]);
  }
  # HOME

  # TASK
  public function postTask(Request $request, Response $response): Response {
    $task = $this->getTaskInfo((int)$_POST['taskId']);

    $_SESSION['users'] = $this->getAllUsers();
    $task['created_by'] = $this->getUsernameFromId((int)$task['created_by']);
    $task['assigned_to'] = $this->getUsernameFromId((int)$task['assigned_to']);

    return $this->view->render($response, "/page/task.twig", ['taskInfo' => $task]);
  }
  # TASK

  # ADD
  public function postAdd(Request $request, Response $response, array $args): Response {
    $_SESSION['users'] = $this->getAllUsers();
    
    return $this->view->render($response, "/page/create.twig", ['userid' => $_SESSION['user']['id'], 'username' => $_SESSION['user']['username'], 'users' => $_SESSION['users']]);
  }
  # ADD

  # CREATE
  public function postCreate(Request $request, Response $response): Response {
    $data = $request->getParsedBody();
    $createdAt = date("Y-m-d H:i:s");

    $this->addTask($_SESSION['user']['id'], (int)$data['taskAssignTo'], $data['taskTitle'], $data['taskDescription'], $createdAt, $data['taskDueDate'].' 23:59:59');

    return $response->withHeader('Location', $this->router->urlFor('home'));
  }
  # CREATE

  private function getUsernameFromId(int $id): string {
    foreach ($_SESSION['users'] as $user) {
      if ((int)$user['id'] == $id) {
        return $user['username'];
      }
    }
    return '';
  }
}

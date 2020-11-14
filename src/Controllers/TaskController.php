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

    if (!$_SESSION['tasks']) {
      $_SESSION['tasks'] = $this->getAllTasks();
    }
    
    return $this->view->render($response, "/page/home.twig", ['username' => $_SESSION['user']['username'], 'tasks' => $_SESSION['tasks']]);
  }
  # HOME

  # TASK
  public function getTask(Request $request, Response $response, array $args) {
    if (!$_SESSION['user']) {
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }

    $taskId = (int)$args['taskId'];
    $task = $this->getTaskInfo($taskId);

    if (!$_SESSION['users']) {
      $_SESSION['users'] = $this->getAllUsers();
    }

    if (!$_SESSION['tasks']) {
      $_SESSION['tasks'] = $this->getAllTasks();
    }
    
    $task['created_by'] = $this->getUsernameFromId((int)$task['created_by'], $_SESSION['users']);
    $task['assigned_to'] = $this->getUsernameFromId((int)$task['assigned_to'], $_SESSION['users']);
    
    $comments = $this->getCommentsByTask($taskId);
    foreach ($comments as $key => $value) {
      $comments[$key]['created_by'] =  $this->getUsernameFromId((int)$comments[$key]['created_by'], $_SESSION['users']);
    }

    return $this->view->render($response, "/page/task.twig", ['username' => $_SESSION['user']['username'], 'tasks' => $_SESSION['tasks'],'taskInfo' => $task, 'comments' => $comments]);
  }
  # TASK

  # ADD
  public function postAdd(Request $request, Response $response, array $args): Response {
    if (!$_SESSION['users']) {
      $_SESSION['users'] = $this->getAllUsers();
    }
    
    return $this->view->render($response, "/page/create.twig", ['userid' => $_SESSION['user']['id'], 'username' => $_SESSION['user']['username'], 'users' => $_SESSION['users']]);
  }
  # ADD

  # CREATE
  public function getCreate(Request $request, Response $response, array $args): Response {
    if (!$_SESSION['user']) {
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }

    if (!$_SESSION['users']) {
      $_SESSION['users'] = $this->getAllUsers();
    }

    if (!$_SESSION['tasks']) {
      $_SESSION['tasks'] = $this->getAllTasks();
    }

    return $this->view->render($response, "/page/create.twig", ['username' => $_SESSION['user']['username'], 'tasks' => $_SESSION['tasks'], 'users' => $_SESSION['users']]);
  }

  public function postCreate(Request $request, Response $response): Response {
    $data = $request->getParsedBody();
    $createdAt = date("Y-m-d H:i:s");

    $taskId = $this->addTask($_SESSION['user']['id'], (int)$data['taskAssignTo'], $data['taskTitle'], $data['taskDescription'], $createdAt, $data['taskDueDate'].' 23:59:59');

    return $response->withHeader('Location', $this->router->urlFor('task', [$taskId]));
  }
  # CREATE

  # COMMENT
  public function postComment(Request $request, Response $response, array $args): Response {
    $data = $request->getParsedBody();
    $taskId = (int)$data['taskId'];
    $commentText = $data['taskComment'];
    $createdAt = date("Y-m-d H:i:s");

    $this->addCommentToTask($taskId, $_SESSION['user']['id'], $createdAt, $commentText);
    
    $comment = array(
      'created_by' => $_SESSION['user']['username'],
      'created_at' => $createdAt,
      'comment' => $commentText
    );
    
    return $response->withHeader('Location', $this->router->urlFor('home'));
  }
  # COMMENT

  private function getUsernameFromId(int $id, array $users): string {
    if ($id == 0) {
      return '';
    }

    foreach ($users as $user) {
      if ((int)$user['id'] == $id) {
        return $user['username'];
      }
    }
    return '';
  }
}

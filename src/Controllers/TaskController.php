<?php
declare(strict_types=1);

namespace Todo\Controllers;

use DI\Container;
use Todo\Models\Task;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class TaskController extends Task
{
  protected Twig $view;
  protected RouteParser $router;

  public function __construct(Container $container) {
    parent::__construct($container);
    $this->view = $container->get('view');
    $this->router = $container->get('router');
  }

  # HOME
  public function getHome(Request $request, Response $response, array $args): Response {
    if (!$_SESSION['user']) {
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }

    if (!$_SESSION['users']) {
      $_SESSION['users'] = $this->getAllUsers();
    }

    if (!$_SESSION['tasks']) {
      $_SESSION['tasks'] = $this->getAllTasks();
      foreach($_SESSION['tasks'] as $key => $value) {
        $_SESSION['tasks'][$key]['created_by'] = $this->getUsernameFromId((int)$_SESSION['tasks'][$key]['created_by'], $_SESSION['users']);
        $_SESSION['tasks'][$key]['assigned_to'] = $this->getUsernameFromId((int)$_SESSION['tasks'][$key]['assigned_to'], $_SESSION['users']);
      }
    }
    
    return $this->view->render($response, "/page/home.twig", ['username' => $_SESSION['user']['username'], 'tasks' => $_SESSION['tasks'], 'userid' => $_SESSION['user']['id'], 'users' => $_SESSION['users']]);
  }
  # HOME

  # TASK
  public function getTask(Request $request, Response $response, array $args): Response {
    if (!$_SESSION['user']) {
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }

    $taskId = (int)$args['taskId'];
    $task = $this->getTaskInfo($taskId);

    if (empty($task)) {
      return $this->view->render($response, "/page/404.twig");
    }

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

    return $this->view->render($response, "/page/task.twig", ['username' => $_SESSION['user']['username'], 'tasks' => $_SESSION['tasks'],'taskInfo' => $task, 'comments' => $comments, 'userid' => $_SESSION['user']['id'], 'users' => $_SESSION['users']]);
  }
  # TASK

  # CREATE
  public function postCreate(Request $request, Response $response): Response {
    $data = $request->getParsedBody();
    $createdAt = date("Y-m-d H:i:s");

    $taskId = $this->addTask($_SESSION['user']['id'], (int)$data['taskAssignTo'], $data['taskTitle'], $data['taskDescription'], $createdAt, $data['taskDueDate'].' 23:59:59');
    
    $_SESSION['tasks'] = $this->getAllTasks();

    return $response->withHeader('Location', $this->router->urlFor('task', ['taskId' => $taskId]));
  }
  # CREATE

  # COMMENT
  public function postComment(Request $request, Response $response, array $args): Response {
    $data = $request->getParsedBody();
    $taskId = (int)$data['taskId'];
    $commentText = $data['taskComment'];
    $createdBy = $this->getUsernameFromId($_SESSION['user']['id'], $_SESSION['users']);
    $createdAt = date("Y-m-d");

    $this->addCommentToTask($taskId, $_SESSION['user']['id'], $createdAt, $commentText);
    
    $comment = array(
      'created_by' => $createdBy,
      'created_at' => $createdAt,
      'comment' => $commentText
    );
    
    return $this->view->render($response, "/template/comment.twig", ['comment' => $comment]);
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

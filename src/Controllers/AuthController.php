<?php
declare(strict_types=1);

namespace Todo\Controllers;

use Todo\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends User
{
  # LOGIN
  public function getLogin(Request $request, Response $response): Response {
    return $this->view->render($response, "/page/login.twig");
  }

  public function postLogin(Request $request, Response $response): Response {
    $data = $request->getParsedBody();

    $id = $this->userLogin($data['username'], $data['password']);
    if ($id != -1) {
      $_SESSION['user']['id'] = $id;
      $_SESSION['user']['username'] = $data['username'];
      return $response->withHeader('Location', $this->router->urlFor('home'));
    }

    return $this->view->render($response, "/page/login.twig", ['message' => true]);
  }
  # LOGIN

  # LOGOUT
  public function logout(Request $request, Response $response): Response {
    session_unset();
    return $response->withHeader('Location', $this->router->urlFor('login'));
  }
  # LOGOUT

  # SIGNUP
  public function getSignup(Request $request, Response $response): Response {
    return $this->view->render($response, "/page/signup.twig");
  }

  public function postSignup(Request $request, Response $response): Response {
    $data = $request->getParsedBody();

    if ($this->userExists($data['username'])) {
      return $this->view->render($response, "/page/signup.twig", [
        'message' => true,
        'alertText' => 'Username already exists!'
      ]);
    }

    if ($data['password'] != $data['passwordRepeat']) {
      return $this->view->render($response, "/page/signup.twig", [
        'message' => true,
        'alertText' => 'Passwords do not match!'
      ]);
    }

    $this->addUser($data['username'], $data['password']);

    return $response->withHeader('Location', $this->router->urlFor('login'));
  }
  #SIGNUP
}

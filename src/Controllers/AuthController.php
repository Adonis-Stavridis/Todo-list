<?php
declare(strict_types=1);

namespace Todo\Controllers;

use DI\Container;
use Todo\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteParser;
use Slim\Views\Twig;

class AuthController extends User
{
  /**
   * @var Twig $view
   */
  protected Twig $view;

  /**
   * @var RouteParser $router
   */
  protected RouteParser $router;

  public function __construct(Container $container) {
    parent::__construct($container);
    $this->view = $container->get('view');
    $this->router = $container->get('router');
  }

  /**
 * Render login page.
 * 
 * @param ServerRequestInterface $request
 * @param ResponseInterface $response
 * 
 * @return Response
 */
  public function getLogin(Request $request, Response $response): Response {
    return $this->view->render($response, "/page/login.twig");
  }

  /**
   * Handle login request.
   * 
   * Gets request data and calls Model to verify credentials. Redirects to home
   * page on success, renders failure message otherwise.
   * 
   * @param ServerRequestInterface $request
   * @param ResponseInterface $response
   * 
   * @return Response
   */
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

  /**
   * Handle logout request.
   * 
   * Redirects to login page.
   * 
   * @param ServerRequestInterface $request
   * @param ResponseInterface $response
   * 
   * @return Response
   */
  public function logout(Request $request, Response $response): Response {
    session_unset();
    return $response->withHeader('Location', $this->router->urlFor('login'));
  }

  /**
   * Render signup page.
   * 
   * @param ServerRequestInterface $request
   * @param ResponseInterface $response
   * 
   * @return Response
   */
  public function getSignup(Request $request, Response $response): Response {
    return $this->view->render($response, "/page/signup.twig");
  }

  /**
   * Handle signup request.
   * 
   * Gets request data and calls Model to verify credentials. Redirects to login
   * page on success, renders failure message otherwise.
   * 
   * @param ServerRequestInterface $request
   * @param ResponseInterface $response
   * 
   * @return Response
   */
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
}

<?php
declare(strict_types=1);

namespace Todo\Features\Login;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class LoginController {
  private LoginService $service;
  private Twig $view;
  private RouteParserInterface $router;

  public function __construct(LoginService $service, Twig $view, RouteParserInterface $router) {
    $this->service = $service;
    $this->view = $view;
    $this->router = $router;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    try {
      $body = json_decode(json_encode($request->getParsedBody()));
      $businessRequest = LoginRequest::from($body);
      $businessResponse = $this->service->handle($businessRequest);

      $_SESSION['user'] = array(
        $businessResponse->getUserId(),
        $businessResponse->getUsername()
      );

      $response->withStatus(200);
      return $response->withHeader('Location', $this->router->urlFor('home'));
    } catch(Exception $exception) {
      $response->withStatus($exception->getCode());
      return $this->view->render($response, "/page/login.twig", ['message' => $exception->getMessage()]);
    }
  }
}

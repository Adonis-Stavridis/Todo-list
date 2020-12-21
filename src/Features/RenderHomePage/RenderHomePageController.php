<?php
declare(strict_types=1);

namespace Todo\Features\RenderHomePage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class RenderHomePageController {
  private Twig $view;
  private RouteParserInterface $router;

  public function __construct(Twig $view, RouteParserInterface $router) {
    $this->view = $view;
    $this->router = $router;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    if (!$_SESSION['user']) {
      $response->withStatus(200);
      return $response->withHeader('Location', $this->router->urlFor('login'));
    }
    
    $response->withStatus(200);
    return $this->view->render($response, "/page/home.twig");
  }
}

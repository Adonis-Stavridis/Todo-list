<?php
declare(strict_types=1);

namespace Todo\Features\RenderLoginPage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class RenderLoginPageController {
  private Twig $view;

  public function __construct(Twig $view) {
    $this->view = $view;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    $response->withStatus(200);
    return $this->view->render($response, "/page/login.twig");
  }
}

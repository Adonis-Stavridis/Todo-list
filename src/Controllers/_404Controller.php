<?php
declare(strict_types=1);

namespace Todo\Controllers;

use DI\Container;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class _404Controller
{
  protected Twig $view;
  
  public function __construct(Container $container) {
    $this->view = $container->get('view');
  }
  
  public function get404(Request $request, Response $response): Response {
    return $this->view->render($response, "/page/404.twig");
  }
}

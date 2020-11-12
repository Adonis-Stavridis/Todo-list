<?php
declare(strict_types=1);

namespace Todo\Controllers;

use Todo\Models\Model;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class _404Controller extends Model
{
  public function get404(Request $request, Response $response): Response {
    return $this->view->render($response, "/page/404.twig");
  }
}

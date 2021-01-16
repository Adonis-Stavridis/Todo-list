<?php

declare(strict_types=1);

namespace TodoWeb\Features\Render404Page;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class Render404PageController
{
	private Twig $view;

	public function __construct(Twig $view)
	{
		$this->view = $view;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		return $this->view->render($response, "/page/404.twig")->withStatus(404);
	}
}

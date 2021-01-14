<?php

declare(strict_types=1);

namespace Todo\Features\Comment;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

class CommentController
{
	private CommentService $service;
	private Twig $view;
	private RouteParserInterface $router;

	public function __construct(CommentService $service, Twig $view, RouteParserInterface $router)
	{
		$this->service = $service;
		$this->view = $view;
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		try {
			$body = json_decode(json_encode($request->getParsedBody()));
			$businessRequest = CommentRequest::from($body);
			$businessResponse = $this->service->handle($businessRequest);

			$response->withStatus(200);
			return $this->view->render($response, "/template/comment.twig", ['comment' => $businessResponse->getComment()]);
		} catch (Exception $exception) {
			$sessionUser = unserialize($_SESSION['user']);
			$sessionUsers = unserialize($_SESSION['users']);
			$sessionTasks = $_SESSION['tasks'];

			$response->withStatus($exception->getCode());
			return $this->view->render($response, "/page/home.twig", [
				'user' => $sessionUser,
				'users' => $sessionUsers,
				'tasks' => $sessionTasks,
				'message' => $exception->getMessage()
			]);
		}
	}
}

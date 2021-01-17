<?php

declare(strict_types=1);

namespace TodoWeb\Features\RenderHomePage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use TodoWeb\Repositories\ApiRepository;
use TodoWeb\Repositories\UserRepository;

class RenderHomePageController
{
	private UserRepository $userRepository;
	private ApiRepository $apiRepository;
	private Twig $view;
	private RouteParserInterface $router;

	public function __construct(UserRepository $userRepository, ApiRepository $apiRepository, Twig $view, RouteParserInterface $router)
	{
		$this->userRepository = $userRepository;
		$this->apiRepository = $apiRepository;
		$this->view = $view;
		$this->router = $router;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		if (!$_SESSION['user']) {
			return $response->withHeader('Location', $this->router->urlFor('login'))->withStatus(200);
		}

		if (!$_SESSION['users']) {
			$_SESSION['users'] = serialize($this->userRepository->getAll());
		}

		if (!$_SESSION['tasks']) {
			$_SESSION['tasks'] = $this->apiRepository->getAll();
		}

		$sessionUser = unserialize($_SESSION['user']);
		$sessionUsers = unserialize($_SESSION['users']);
		$sessionTasks = $_SESSION['tasks'];

		return $this->view->render($response, "/page/home.twig", [
			'user' => $sessionUser,
			'users' => $sessionUsers,
			'tasks' => $sessionTasks
		])->withStatus(200);
	}
}

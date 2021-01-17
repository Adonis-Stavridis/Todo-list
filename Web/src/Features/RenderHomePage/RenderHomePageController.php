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
	/**
	 * @var UserRepository $userRepository
	 */
	private UserRepository $userRepository;

	/**
	 * @var ApiRepository $apiRepository
	 */
	private ApiRepository $apiRepository;

	/**
	 * @var Twig $view
	 */
	private Twig $view;

	/**
	 * @var RouteParserInterface $router
	 */
	private RouteParserInterface $router;

	/**
	 * Constructor function
	 * 
	 * @param UserRepository $userRepository
	 * @param ApiRepository $apiRepository
	 * @param Twig $view
	 * @param RouteParserInterface $router
	 * 
	 * @return static
	 */
	public function __construct(UserRepository $userRepository, ApiRepository $apiRepository, Twig $view, RouteParserInterface $router)
	{
		$this->userRepository = $userRepository;
		$this->apiRepository = $apiRepository;
		$this->view = $view;
		$this->router = $router;
	}

	/**
	 * Invoke function handle request and send response
	 * 
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * 
	 * @return ResponseInterface
	 */
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

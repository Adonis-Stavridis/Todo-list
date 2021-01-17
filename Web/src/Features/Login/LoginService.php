<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use TodoWeb\Repositories\UserRepository;

class LoginService
{
	/**
	 * @var UserRepository $repository
	 */
	private UserRepository $repository;

	/**
	 * Constructor function
	 * 
	 * @param UserRepository $repository
	 * 
	 * @return static
	 */
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Service handler
	 * 
	 * @param LoginRequest $request
	 * 
	 * @return LoginResponse
	 */
	public function handle(LoginRequest $request): LoginResponse
	{
		$userArray = $this->repository->getUser($request);

		if (!$userArray || !password_verify($request->getPassword(), $userArray['password'])) {
			throw new IncorrectUsernameOrPasswordException();
		}

		return new LoginResponse($userArray['user']);
	}
}

<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use TodoWeb\Models\User;
use TodoWeb\Repositories\UserRepository;

class LoginService
{
	private UserRepository $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(LoginRequest $request): LoginResponse
	{
		$userArray = $this->repository->getUser($request);

		if (!$userArray || !password_verify($request->getPassword(), $userArray['password'])) {
			throw new IncorrectUsernameOrPasswordException();
		}

		return new LoginResponse($userArray['user']);
	}
}

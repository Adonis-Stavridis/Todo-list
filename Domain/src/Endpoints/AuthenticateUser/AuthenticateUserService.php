<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\AuthenticateUser;

use TodoDomain\Repositories\UserRepository;

class AuthenticateUserService
{
	private UserRepository $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(AuthenticateUserRequest $user): AuthenticateUserResponse
	{
		$username = $user->getUsername();
		$password = $user->getPassword();

		$userArray = $this->repository->getUser($username);

		if (!$userArray || !password_verify($password, $userArray['password'])) {
			throw new IncorrectUsernameOrPasswordException();
		}

		return new AuthenticateUserResponse($userArray['user']);
	}
}

<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\CreateUser;

use TodoDomain\Repositories\UserRepository;

class CreateUserService
{
	private UserRepository $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(CreateUserRequest $user): void
	{
		$flag = $this->repository->addUser($user);
		if (!$flag) {
			throw new CouldNotCreateUserException();
		}
	}
}

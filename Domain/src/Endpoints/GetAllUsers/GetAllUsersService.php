<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\GetAllUsers;

use TodoDomain\Repositories\UserRepository;

class GetAllUsersService
{
	private UserRepository $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(): array
	{
		$users = $this->repository->getAll();
		if (empty($users)) {
			throw new NoUsersException();
		}

		return $users;
	}
}

<?php

declare(strict_types=1);

namespace TodoDomain\Repositories;

use TodoDomain\Endpoints\CreateUser\CreateUserRequest;

interface UserRepository
{
	public function getUser(string $username): ?array;
	public function getAll(): array;
	public function addUser(CreateUserRequest $user): bool;
	public function userExists(string $username): bool;
}

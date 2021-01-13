<?php

declare(strict_types=1);

namespace Todo\Repositories;

use Todo\Features\Signup\SignupRequest;

interface UserRepository
{
	public function getUser(string $username): array;
	public function getAll(): array;
	public function addUser(SignupRequest $signup): bool;
	public function userExists(string $username): bool;
}

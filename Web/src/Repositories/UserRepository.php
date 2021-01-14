<?php

declare(strict_types=1);

namespace TodoWeb\Repositories;

use TodoWeb\Features\Signup\SignupRequest;

interface UserRepository
{
	public function getUser(string $username): array;
	public function getAll(): array;
	public function addUser(SignupRequest $signup): bool;
	public function userExists(string $username): bool;
}

<?php

declare(strict_types=1);

namespace TodoWeb\Repositories;

use TodoWeb\Models\User;
use TodoWeb\Features\Login\LoginRequest;
use TodoWeb\Features\Signup\SignupRequest;

interface UserRepository
{
	public function getUser(LoginRequest $request): ?User;
	public function getAll(): array;
	public function addUser(SignupRequest $signup): bool;
	public function userExists(string $username): bool;
}

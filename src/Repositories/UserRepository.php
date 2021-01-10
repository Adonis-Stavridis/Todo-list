<?php

declare(strict_types=1);

namespace Todo\Repositories;

interface UserRepository
{
	public function getUser(string $username): array;
	public function getAll(): array;
	public function addUser(string $username, string $password): bool;
	public function userExists(string $username): bool;
}
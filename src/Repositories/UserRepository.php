<?php
declare(strict_types=1);

namespace Todo\Repositories;

interface UserRepository {
  public function getAll(): array;
  public function getUser(string $username);
  public function userExists(string $username);
  public function addUser(string $username, string $password);
}

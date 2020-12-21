<?php
declare(strict_types=1);

namespace Todo\Features\Login;

class LoginResponse {
  private int $userId;
  private string $username;

  public function __construct(int $userId, string $username) {
    $this->userId = $userId;
    $this->username = $username;
  }

  public function getUserId(): int {
    return $this->userId;
  }

  public function getUsername(): string {
    return $this->username;
  }
}

<?php
declare(strict_types=1);

namespace Todo\Features\Login;

use Todo\Models\User;

class LoginResponse {
  private User $user;

  public function __construct(User $user) {
    $this->user = $user;
  }

  public function getUser(): User {
    return $this->user;
  }
}

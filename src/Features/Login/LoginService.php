<?php
declare(strict_types=1);

namespace Todo\Features\Login;

use Todo\Repositories\UserRepository;

class LoginService {
  private UserRepository $repository;

  public function __construct(UserRepository $repository) {
    $this->repository = $repository;
  }

  public function handle(LoginRequest $request): LoginResponse {
    $username = $request->getUsername();
    $password = $request->getPassword();

    $query = $this->repository->getUser($username);
    if (!$query || !password_verify($password, $query['password'])) {
      throw new IncorrectUsernameOrPasswordException();
    }

    return new LoginResponse((int)$query['id'],$username);
  }
}

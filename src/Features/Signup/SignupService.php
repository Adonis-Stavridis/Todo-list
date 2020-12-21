<?php
declare(strict_types=1);

namespace Todo\Features\Signup;

use Todo\Repositories\UserRepository;

class SignupService {
  private UserRepository $repository;

  public function __construct(UserRepository $repository) {
    $this->repository = $repository;
  }

  public function handle(SignupRequest $request): void {
    $username = $request->getUsername();
    $password = $request->getPassword();
    $passwordRepeat = $request->getPasswordRepeat();

    $query = $this->repository->userExists($username);
    if ($query) {
      throw new UsernameAlreadyExistsException();
    }

    if ($password != $passwordRepeat) {
      throw new PasswordsDoNotMatchException();
    }

    $query = $this->repository->addUser($username, $password);
    if (!$query) {
      throw new CouldNotSignupUserException();
    }
  }
}

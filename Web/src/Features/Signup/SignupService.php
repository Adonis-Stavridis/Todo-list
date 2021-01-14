<?php

declare(strict_types=1);

namespace TodoWeb\Features\Signup;

use TodoWeb\Repositories\UserRepository;

class SignupService
{
	private UserRepository $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(SignupRequest $request): void
	{
		$username = $request->getUsername();
		$password = $request->getPassword();
		$passwordRepeat = $request->getPasswordRepeat();

		$boolean = $this->repository->userExists($username);
		if ($boolean) {
			throw new UsernameAlreadyExistsException();
		}

		if ($password != $passwordRepeat) {
			throw new PasswordsDoNotMatchException();
		}

		$boolean = $this->repository->addUser($request);
		if (!$boolean) {
			throw new CouldNotSignupUserException();
		}
	}
}

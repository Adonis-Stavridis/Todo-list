<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\AuthenticateUser;

use TodoDomain\Models\User;

class AuthenticateUserResponse
{
	private User $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getUser(): User
	{
		return $this->user;
	}
}

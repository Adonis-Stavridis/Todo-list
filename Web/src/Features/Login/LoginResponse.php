<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use TodoWeb\Models\User;

class LoginResponse
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

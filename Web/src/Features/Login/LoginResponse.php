<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use TodoWeb\Models\User;

class LoginResponse
{
	/**
	 * @var User $user
	 */
	private User $user;

	/**
	 * Constructor function
	 * 
	 * @param User $user
	 * 
	 * @return static
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * User getter
	 * 
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}
}

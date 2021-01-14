<?php

declare(strict_types=1);

namespace TodoWeb\Features\Signup;

use Exception;

class UsernameAlreadyExistsException extends Exception
{
	public function __construct(Exception $previous = null)
	{
		parent::__construct("Username already exists", 400, $previous);
	}
}

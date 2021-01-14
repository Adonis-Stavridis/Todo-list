<?php

declare(strict_types=1);

namespace TodoWeb\Features\Signup;

use Exception;

class PasswordsDoNotMatchException extends Exception
{
	public function __construct(Exception $previous = null)
	{
		parent::__construct("Passwords do not match", 400, $previous);
	}
}

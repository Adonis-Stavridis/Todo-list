<?php

declare(strict_types=1);

namespace Todo\Features\Login;

use Exception;

class IncorrectUsernameOrPasswordException extends Exception
{
	public function __construct(Exception $previous = null)
	{
		parent::__construct("Incorrect username or password", 400, $previous);
	}
}

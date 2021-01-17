<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use Exception;

class IncorrectUsernameOrPasswordException extends Exception
{
	/**
	 * Constructor function
	 * 
	 * @param Exception $previous (null by default)
	 * 
	 * @return mixed
	 */
	public function __construct(Exception $previous = null)
	{
		parent::__construct("Incorrect username or password", 400, $previous);
	}
}

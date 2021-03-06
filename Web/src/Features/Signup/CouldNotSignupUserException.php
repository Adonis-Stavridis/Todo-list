<?php

declare(strict_types=1);

namespace TodoWeb\Features\Signup;

use Exception;

class CouldNotSignupUserException extends Exception
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
		parent::__construct("Could not signup, try again later", 500, $previous);
	}
}

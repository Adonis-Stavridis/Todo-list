<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\CreateUser;

use Exception;

class CouldNotCreateUserException extends Exception
{
	public function __construct(Exception $previous = null)
	{
		parent::__construct("Could not create user", 500, $previous);
	}
}

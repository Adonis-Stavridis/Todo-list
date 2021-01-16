<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\GetAllUsers;

use Exception;

class NoUsersException extends Exception
{
	public function __construct(Exception $previous = null)
	{
		parent::__construct("No users found", 400, $previous);
	}
}

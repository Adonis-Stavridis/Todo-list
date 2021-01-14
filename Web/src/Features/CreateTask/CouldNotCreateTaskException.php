<?php

declare(strict_types=1);

namespace TodoWeb\Features\CreateTask;

use Exception;

class CouldNotCreateTaskException extends Exception
{
	public function __construct(Exception $previous = null)
	{
		parent::__construct("Could not create task, try again later", 400, $previous);
	}
}

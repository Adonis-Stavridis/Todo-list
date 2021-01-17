<?php

declare(strict_types=1);

namespace TodoWeb\Features\CreateTask;

use Exception;

class CouldNotCreateTaskException extends Exception
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
		parent::__construct("Could not create task, try again later", 400, $previous);
	}
}

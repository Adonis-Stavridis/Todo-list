<?php

declare(strict_types=1);

namespace TodoWeb\Features\Comment;

use Exception;

class CouldNotCommentException extends Exception
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
		parent::__construct("Could not comment, try again later", 400, $previous);
	}
}

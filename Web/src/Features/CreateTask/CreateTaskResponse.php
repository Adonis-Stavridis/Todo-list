<?php

declare(strict_types=1);

namespace TodoWeb\Features\CreateTask;

class CreateTaskResponse
{
	/**
	 * @var int $taskId
	 */
	private int $taskId;

	/**
	 * Constructor function
	 * 
	 * @param int $taskId
	 * 
	 * @return static
	 */
	public function __construct(int $taskId)
	{
		$this->taskId = $taskId;
	}

	/**
	 * TaskId getter
	 * 
	 * @return int
	 */
	public function getTaskId(): int
	{
		return $this->taskId;
	}
}

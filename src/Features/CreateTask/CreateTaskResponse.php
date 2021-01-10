<?php

declare(strict_types=1);

namespace Todo\Features\CreateTask;

class CreateTaskResponse
{
	private int $taskId;

	public function __construct(int $taskId)
	{
		$this->taskId = $taskId;
	}

	public function getTaskId(): int
	{
		return $this->taskId;
	}
}

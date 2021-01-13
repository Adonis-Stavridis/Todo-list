<?php

declare(strict_types=1);

namespace Todo\Features\CreateTask;

use Todo\Repositories\TaskRepository;

class CreateTaskService
{
	private TaskRepository $repository;

	public function __construct(TaskRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(CreateTaskRequest $request): CreateTaskResponse
	{
		$taskId = $this->repository->addTask($request);
		if ($taskId == -1) {
			throw new CouldNotCreateTaskException();
		}

		return new CreateTaskResponse($taskId);
	}
}

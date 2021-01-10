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
		$createdBy = $request->getUserId();
		$assignedTo = $request->getAssignTo();
		$title = $request->getTitle();
		$description = $request->getDescription();
		$createdAt = $request->getCreatedAt();
		$dueDate = $request->getDueDate();

		$taskId = $this->repository->addTask($createdBy, $assignedTo, $title, $description, $createdAt, $dueDate);
		if ($taskId == -1) {
			throw new CouldNotCreateTaskException();
		}

		return new CreateTaskResponse($taskId);
	}
}

<?php

declare(strict_types=1);

namespace TodoWeb\Features\CreateTask;

use TodoWeb\Repositories\TaskRepository;

class CreateTaskService
{
	/**
	 * @var TaskRepository $repository
	 */
	private TaskRepository $repository;

	/**
	 * Constructor function
	 * 
	 * @param TaskRepository $repository
	 * 
	 * @return static
	 */
	public function __construct(TaskRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Service handler
	 * 
	 * @param CreateTaskRequest $request
	 * 
	 * @return CreateTaskResponse
	 */
	public function handle(CreateTaskRequest $request): CreateTaskResponse
	{
		$taskId = $this->repository->addTask($request);
		if ($taskId == -1) {
			throw new CouldNotCreateTaskException();
		}

		return new CreateTaskResponse($taskId);
	}
}

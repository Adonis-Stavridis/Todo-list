<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\Tasks;

use TodoDomain\Repositories\TaskRepository;

class TasksService
{
	private TaskRepository $repository;

	public function __construct(TaskRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(): array
	{
		$tasks = $this->repository->getAll();

		return $tasks;
	}
}

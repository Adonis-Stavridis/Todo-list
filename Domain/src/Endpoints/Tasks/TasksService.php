<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\Tasks;

use TodoDomain\Repositories\TaskRepository;

class TasksService
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
	 * Handler function that calls database
	 * 
	 * @return array
	 */
	public function handle(): array
	{
		$tasks = $this->repository->getAll();

		return $tasks;
	}
}

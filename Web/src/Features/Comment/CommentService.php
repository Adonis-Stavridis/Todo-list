<?php

declare(strict_types=1);

namespace TodoWeb\Features\Comment;

use TodoWeb\Repositories\TaskRepository;

class CommentService
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
	 * @param CommentRequest $request
	 * 
	 * @return CommentResponse
	 */
	public function handle(CommentRequest $request): CommentResponse
	{
		$newComment = $this->repository->addTaskComment($request);
		if (!$newComment) {
			throw new CouldNotCommentException();
		}

		return new CommentResponse($newComment);
	}
}

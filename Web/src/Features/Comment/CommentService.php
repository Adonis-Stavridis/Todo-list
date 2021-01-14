<?php

declare(strict_types=1);

namespace TodoWeb\Features\Comment;

use TodoWeb\Repositories\TaskRepository;

class CommentService
{
	private TaskRepository $repository;

	public function __construct(TaskRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(CommentRequest $request): CommentResponse
	{
		$newComment = $this->repository->addTaskComment($request);
		if (!$newComment) {
			throw new CouldNotCommentException();
		}

		return new CommentResponse($newComment);
	}
}

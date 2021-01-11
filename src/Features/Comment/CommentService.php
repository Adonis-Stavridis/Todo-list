<?php

declare(strict_types=1);

namespace Todo\Features\Comment;

use Todo\Models\Comment;
use Todo\Repositories\TaskRepository;

class CommentService
{
	private TaskRepository $repository;

	public function __construct(TaskRepository $repository)
	{
		$this->repository = $repository;
	}

	public function handle(CommentRequest $request): CommentResponse
	{
		$taskId = $request->getTaskId();
		$createdBy = $request->getCreatedBy();
		$createdAt = $request->getCreatedAt();
		$comment = $request->getComment();

		$newComment = $this->repository->addTaskComment($taskId, $createdBy, $createdAt, $comment);
		if (!$newComment) {
			throw new CouldNotCommentException();
		}

		return new CommentResponse($newComment);
	}
}

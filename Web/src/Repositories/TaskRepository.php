<?php

declare(strict_types=1);

namespace Todo\Repositories;

use Todo\Features\Comment\CommentRequest;
use Todo\Features\CreateTask\CreateTaskRequest;
use Todo\Models\Comment;
use Todo\Models\Task;

interface TaskRepository
{
	public function getTask(int $taskId): Task;
	public function getAll(): array;
	public function addTask(CreateTaskRequest $task): int;
	public function getTaskComments(int $taskId): array;
	public function addTaskComment(CommentRequest $comment): Comment;
}

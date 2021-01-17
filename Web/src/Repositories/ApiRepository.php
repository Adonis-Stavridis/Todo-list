<?php

declare(strict_types=1);

namespace TodoWeb\Repositories;

use TodoWeb\Features\Comment\CommentRequest;
use TodoWeb\Features\CreateTask\CreateTaskRequest;
use TodoWeb\Models\Comment;
use TodoWeb\Models\Task;

interface ApiRepository
{
	public function getTask(int $taskId): Task;
	public function getAll(): array;
	public function addTask(CreateTaskRequest $task): int;
	public function getTaskComments(int $taskId): array;
	public function addTaskComment(CommentRequest $comment): Comment;
}

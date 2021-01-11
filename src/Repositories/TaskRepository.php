<?php

declare(strict_types=1);

namespace Todo\Repositories;

use Todo\Models\Comment;
use Todo\Models\Task;

interface TaskRepository
{
	public function getTask(int $taskId): Task;
	public function getAll(): array;
	public function addTask(int $createdBy, int $assignedTo, string $title, string $description, string $createdAt, string $dueDate): int;
	public function getTaskComments(int $taskId): array;
	public function addTaskComment(int $taskId, int $createdBy, string $createdAt, string $comment): Comment;
}

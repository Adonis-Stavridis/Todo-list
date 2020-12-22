<?php
declare(strict_types=1);

namespace Todo\Repositories;

use Todo\Models\Task;

interface TaskRepository {
  public function getTask(int $id): Task;
  public function getAll(): array;
  public function addTask(int $createdBy, int $assignedTo, string $title, string $description, string $createdAt, string $dueDate): bool;
  // public function getTaskComments(int $id): array;
  // public function addTaskComment(): bool;
}

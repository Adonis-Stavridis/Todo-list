<?php
declare(strict_types=1);

namespace Todo\Models;

class Task extends Model {
  protected function getTaskInfo(int $id): array {
    $query = 'SELECT * FROM todos WHERE id = ?';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->fetch();

    return $res;
  }

  protected function getAllTasks(): array {
    $query = 'SELECT * FROM todos';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();

    return $res;
  }

  protected function addTask(int $createdBy, int $assignTo, string $title, string $description, string $createdAt, string $dueDate): void {
    $query = 'INSERT INTO todos (created_by, assigned_to, title, description, created_at, due_date) VALUES ( ? , ? , ? , ? , ? , ? )';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$createdBy, $assignTo, $title, $description, $createdAt, $dueDate]);
  }

  protected function getAllUsers(): array {
    $query = 'SELECT id,username FROM users';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();

    return $res;
  }
}

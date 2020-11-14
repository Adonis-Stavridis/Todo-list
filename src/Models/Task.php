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

  protected function addTask(int $createdBy, int $assignTo, string $title, string $description, string $createdAt, string $dueDate): string {
    $query = 'INSERT INTO todos (created_by, assigned_to, title, description, created_at, due_date) VALUES ( ? , ? , ? , ? , ? , ? )';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$createdBy, $assignTo, $title, $description, $createdAt, $dueDate]);
    
    return $this->db->lastInsertId();
  }

  protected function getAllUsers(): array {
    $query = 'SELECT id,username FROM users';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();

    return $res;
  }

  protected function addCommentToTask(int $taskId, int $createdBy, string $createdAt, string $comment): string {
    $query = 'INSERT INTO comments (task_id, created_by, created_at, comment) VALUES ( ? , ? , ? , ? )';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$taskId, $createdBy, $createdAt, $comment]);
    
    return $this->db->lastInsertId();
  }

  protected function getCommentsByTask(int $id): array {
    $query = 'SELECT id, created_by, created_at, comment FROM comments WHERE task_id = ? ORDER BY created_at DESC';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->fetchAll();

    return $res;
  }
}

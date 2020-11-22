<?php
declare(strict_types=1);

namespace Todo\Models;

class Task extends Model {
  /**
   * Get task information.
   * 
   * @param int $id
   * 
   * @return array
   */
  protected function getTaskInfo(int $id): array {
    $query = 'SELECT * FROM todos WHERE id = ?';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->fetch();
    
    if (!$res) {
      $res = [];
    }

    return $res;
  }

  /**
   * Get all tasks information.
   * 
   * @return array
   */
  protected function getAllTasks(): array {
    $query = 'SELECT * FROM todos';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();

    return $res;
  }

  /**
   * Add task.
   * 
   * @param int $createdBy
   * @param int $assignTo
   * @param string $title
   * @param string $description
   * @param string $createdAt
   * @param string $dueDate
   * 
   * @return string
   */
  protected function addTask(int $createdBy, int $assignTo, string $title, string $description, string $createdAt, string $dueDate): string {
    $query = 'INSERT INTO todos (created_by, assigned_to, title, description, created_at, due_date) VALUES ( ? , ? , ? , ? , ? , ? )';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$createdBy, $assignTo, $title, $description, $createdAt, $dueDate]);
    
    return $this->db->lastInsertId();
  }

  
  /**
   * Get all usernames and ids.
   * 
   * @return array
   */
  protected function getAllUsers(): array {
    $query = 'SELECT id,username FROM users';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();

    return $res;
  }

  /**
   * Add comment of task.
   * 
   * @param int $taskId
   * @param int $createdBy
   * @param string $createdAt
   * @param string $comment
   * 
   * @return string
   */
  protected function addCommentToTask(int $taskId, int $createdBy, string $createdAt, string $comment): string {
    $query = 'INSERT INTO comments (task_id, created_by, created_at, comment) VALUES ( ? , ? , ? , ? )';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$taskId, $createdBy, $createdAt, $comment]);
    
    return $this->db->lastInsertId();
  }

  /**
   * Get comment of task.
   * 
   * @param int $taskId
   * 
   * @return array
   */
  protected function getCommentsByTask(int $taskId): array {
    $query = 'SELECT created_by, created_at, comment FROM comments WHERE task_id = ? ORDER BY id ASC';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$taskId]);
    $res = $stmt->fetchAll();

    return $res;
  }
}

<?php
declare(strict_types=1);

namespace Todo\Repositories\PDO;

use PDO;
use Todo\Models\Task;
use Todo\Repositories\TaskRepository;

class PDOTaskRepository implements TaskRepository {
  private PDO $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function getTask(int $id): Task {
    $query = 'SELECT t.id, u1.username as created_by, u2.username as assigned_to, t.title, t.description, t.created_at, t.due_date FROM todos t JOIN users u1 on t.created_by = u1.id JOIN users u2 on t.assigned_to = u2.id where t.id = ?';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$id]);
    $res = $stmt->fetch();

    return new Task((int)$res['id'], $res['created_by'], $res['assigned_to'], $res['title'], $res['description'], $res['created_at'], $res['due_date']);
  }

  public function getAll(): array {
    $query = 'SELECT id, title FROM todos';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $res = $stmt->fetchAll();

    $tasks = [];
    foreach($res as $key) {
      array_push($tasks, array('id' => $key['id'], 'title' => $key['title']));
    }

    return $tasks;
  }

  public function addTask(int $createdBy, int $assignedTo, string $title, string $description, string $createdAt, string $dueDate): bool {
    $query = 'INSERT INTO todos (created_by, assigned_to, title, description, created_at, due_date) VALUES ( ? , ? , ? , ? , ? , ? )';
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$createdBy, $assignedTo, $title, $description, $createdAt, $dueDate]);
    
    return $this->pdo->lastInsertId() ?  true : false;
  }

  // public function getTaskComments(string $username): array {}
  
  // public function addTaskComment(): bool {}
}

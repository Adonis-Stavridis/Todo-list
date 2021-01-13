<?php

declare(strict_types=1);

namespace Todo\Repositories\PDO;

use PDO;
use Todo\Features\Comment\CommentRequest;
use Todo\Features\CreateTask\CreateTaskRequest;
use Todo\Models\Comment;
use Todo\Models\Task;
use Todo\Repositories\TaskRepository;

class PDOTaskRepository implements TaskRepository
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getTask(int $taskId): Task
	{
		$query = 'SELECT t.id, u1.username AS created_by, u2.username AS assigned_to, t.title, t.description, t.created_at, t.due_date FROM todos t JOIN users u1 ON t.created_by = u1.id JOIN users u2 ON t.assigned_to = u2.id WHERE t.id = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$taskId]);
		$res = $stmt->fetch();

		return new Task((int)$res['id'], $res['created_by'], $res['assigned_to'], $res['title'], $res['description'], $res['created_at'], $res['due_date']);
	}

	public function getAll(): array
	{
		$query = 'SELECT t.id, u1.username AS created_by, u2.username AS assigned_to, t.title FROM todos t JOIN users u1 ON t.created_by = u1.id JOIN users u2 ON t.assigned_to = u2.id ORDER BY t.id ASC';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$res = $stmt->fetchAll();

		$tasks = [];
		foreach ($res as $key) {
			$tasks[] =  array('id' => $key['id'], 'title' => $key['title'], 'createdBy' => $key['created_by'], 'assignedTo' => $key['assigned_to']);
		}

		return $tasks;
	}

	public function addTask(CreateTaskRequest $task): int
	{
		$query = 'INSERT INTO todos (created_by, assigned_to, title, description, created_at, due_date) VALUES ( ? , ? , ? , ? , ? , ? )';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([
			$task->getCreatedBy(),
			$task->getAssignTo(),
			$task->getTitle(),
			$task->getDescription(),
			$task->getCreatedAt(),
			$task->getDueDate()
		]);

		$taskId	= $this->pdo->lastInsertId();

		return $taskId ? (int)$taskId : -1;
	}

	public function getTaskComments(int $taskId): array
	{
		$query = 'SELECT u.username AS created_by, c.created_at, c.comment FROM comments c JOIN users u ON c.created_by = u.id WHERE c.task_id = ? ORDER BY c.id ASC';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$taskId]);
		$res = $stmt->fetchAll();

		$comments = [];
		foreach ($res as $value) {
			$comments[] = new Comment($value['created_by'], $value['created_at'], $value['comment']);
		}

		return $comments;
	}

	public function addTaskComment(CommentRequest $comment): Comment
	{
		$query = 'INSERT INTO comments (task_id, created_by, created_at, comment) VALUES ( ? , ? , ? , ? )';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([
			$comment->getTaskId(),
			$comment->getCreatedBy(),
			$comment->getCreatedAt(),
			$comment->getComment()
		]);

		$query = 'SELECT username FROM users WHERE id = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$comment->getCreatedBy()]);
		$res = $stmt->fetch();

		$newComment = new Comment($res['username'], $comment->getCreatedAt(), $comment->getComment());

		return $newComment;
	}
}

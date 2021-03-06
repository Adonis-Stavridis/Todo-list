<?php

declare(strict_types=1);

namespace TodoWeb\Repositories\PDO;

use PDO;
use TodoWeb\Features\Comment\CommentRequest;
use TodoWeb\Features\CreateTask\CreateTaskRequest;
use TodoWeb\Models\Comment;
use TodoWeb\Models\Task;
use TodoWeb\Repositories\TaskRepository;

class PDOTaskRepository implements TaskRepository
{
	/**
	 * @var PDO $pdo
	 */
	private PDO $pdo;

	/**
	 * Constructor function
	 * 
	 * @param PDO $pdo
	 * 
	 * @return static
	 */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Get a task
	 * 
	 * @param int $taskId
	 * 
	 * @return Task
	 */
	public function getTask(int $taskId): Task
	{
		$query = 'SELECT t.id, u1.username AS created_by, u2.username AS assigned_to, t.title, t.description, t.created_at, t.due_date FROM todos t JOIN users u1 ON t.created_by = u1.id JOIN users u2 ON t.assigned_to = u2.id WHERE t.id = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$taskId]);
		$res = $stmt->fetch();

		return new Task((int)$res['id'], $res['created_by'], $res['assigned_to'], $res['title'], $res['description'], $res['created_at'], $res['due_date']);
	}

	/**
	 * Get all tasks
	 * 
	 * @return array
	 */
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

	/**
	 * Add a task
	 * 
	 * @param CreateTaskRequest $task
	 * 
	 * @return int
	 */
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

	/**
	 * Get task comments
	 * 
	 * @param int $taskId
	 * 
	 * @return array
	 */
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

	/**
	 * Add comment to task
	 * 
	 * @param CommentRequest $comment
	 * 
	 * @return Comment
	 */
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

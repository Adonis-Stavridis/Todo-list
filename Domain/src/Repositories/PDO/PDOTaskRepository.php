<?php

declare(strict_types=1);

namespace TodoDomain\Repositories\PDO;

use PDO;
use TodoDomain\Repositories\TaskRepository;

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
}

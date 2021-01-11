<?php

declare(strict_types=1);

namespace Todo\Features\CreateTask;

use stdClass;

class CreateTaskRequest
{
	private int $userId;
	private int $assignTo;
	private string $title;
	private string $description;
	private string $createdAt;
	private string $dueDate;

	public function __construct(int $assignTo, string $title, string $description, string $dueDate)
	{
		$this->userId = unserialize($_SESSION['user'])->getId();
		$this->assignTo = $assignTo;
		$this->title = $title;
		$this->description = $description;
		$this->createdAt = date("Y-m-d");
		$this->dueDate = $dueDate;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function getAssignTo()
	{
		return $this->assignTo;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getDueDate()
	{
		return $this->dueDate;
	}

	public static function from(stdClass $json)
	{
		return new self((int)$json->taskAssignTo, $json->taskTitle, $json->taskDescription, $json->taskDueDate);
	}
}

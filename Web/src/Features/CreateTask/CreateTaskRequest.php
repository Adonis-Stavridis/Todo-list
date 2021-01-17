<?php

declare(strict_types=1);

namespace TodoWeb\Features\CreateTask;

use stdClass;

class CreateTaskRequest
{
	/**
	 * @var int $createdBy
	 */
	private int $createdBy;

	/**
	 * @var int $assignTo
	 */
	private int $assignTo;

	/**
	 * @var string $title
	 */
	private string $title;

	/**
	 * @var string $description
	 */
	private string $description;

	/**
	 * @var string $createdAt
	 */
	private string $createdAt;

	/**
	 * @var string $dueDate
	 */
	private string $dueDate;

	/**
	 * Constructor function
	 * 
	 * @var int $createdBy
	 * @var int $assignTo
	 * @var string $title
	 * @var string $description
	 * @var string $createdAt
	 * @var string $dueDate
	 * 
	 * @return static
	 */
	public function __construct(int $assignTo, string $title, string $description, string $dueDate)
	{
		$this->createdBy = unserialize($_SESSION['user'])->getId();
		$this->assignTo = $assignTo;
		$this->title = $title;
		$this->description = $description;
		$this->createdAt = date("Y-m-d");
		$this->dueDate = $dueDate;
	}

	/**
	 * CreatedBy getter
	 * 
	 * @return int
	 */
	public function getCreatedBy(): int
	{
		return $this->createdBy;
	}

	/**
	 * AssignTo getter
	 * 
	 * @return int
	 */
	public function getAssignTo(): int
	{
		return $this->assignTo;
	}

	/**
	 * Title getter
	 * 
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * Description getter
	 * 
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * CreatedAt getter
	 * 
	 * @return string
	 */
	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	/**
	 * DueDate getter
	 * 
	 * @return string
	 */
	public function getDueDate(): string
	{
		return $this->dueDate;
	}

	/**
	 * Call constructor with stdClass
	 * 
	 * @param stdClass $json
	 * 
	 * @return static
	 */
	public static function from(stdClass $json)
	{
		return new self((int)$json->taskAssignTo, $json->taskTitle, $json->taskDescription, $json->taskDueDate);
	}
}

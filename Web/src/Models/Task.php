<?php

declare(strict_types=1);

namespace TodoWeb\Models;

class Task
{
	/**
	 * @var int $id
	 */
	private int $id;

	/**
	 * @var string $createdBy
	 */
	private string $createdBy;

	/**
	 * @var string $assignedTo
	 */
	private string $assignedTo;

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
	 * @param int $id
	 * @param string $createdBy
	 * @param string $assignedTo
	 * @param string $title
	 * @param string $description
	 * @param string $createdAt
	 * @param string $dueDate
	 * 
	 * @return static
	 */
	public function __construct(int $id, string $createdBy, string $assignedTo, string $title, string $description, string $createdAt, string $dueDate)
	{
		$this->id = $id;
		$this->createdBy = $createdBy;
		$this->assignedTo = $assignedTo;
		$this->title = $title;
		$this->description = $description;
		$this->createdAt = $createdAt;
		$this->dueDate = $dueDate;
	}

	/**
	 * Id getter
	 * 
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * CreatedBy getter
	 * 
	 * @return string
	 */
	public function getCreatedBy(): string
	{
		return $this->createdBy;
	}

	/**
	 * AssignedTo getter
	 * 
	 * @return string
	 */
	public function getAssignedTo(): string
	{
		return $this->assignedTo;
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
}

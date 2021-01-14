<?php

declare(strict_types=1);

namespace TodoWeb\Models;

class Task
{
	private int $id;
	private string $createdBy;
	private string $assignedTo;
	private string $title;
	private string $description;
	private string $createdAt;
	private string $dueDate;

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

	public function getId(): int
	{
		return $this->id;
	}

	public function getCreatedBy(): string
	{
		return $this->createdBy;
	}

	public function getAssignedTo(): string
	{
		return $this->assignedTo;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function getDueDate(): string
	{
		return $this->dueDate;
	}
}

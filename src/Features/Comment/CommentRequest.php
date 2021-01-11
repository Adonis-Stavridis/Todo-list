<?php

declare(strict_types=1);

namespace Todo\Features\Comment;

use stdClass;

class CommentRequest
{
	private int $taskId;
	private int $createdBy;
	private string $createdAt;
	private string $comment;

	public function __construct(int $taskId, string $comment)
	{
		$this->taskId = $taskId;
		$this->createdBy = unserialize($_SESSION['user'])->getId();
		$this->createdAt = date("Y-m-d");
		$this->comment = $comment;
	}

	public function getTaskId()
	{
		return $this->taskId;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public static function from(stdClass $json)
	{
		return new self((int)$json->taskId, $json->comment);
	}
}

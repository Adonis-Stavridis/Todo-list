<?php

declare(strict_types=1);

namespace TodoWeb\Features\Comment;

use stdClass;

class CommentRequest
{
	/**
	 * @var int $taskId
	 */
	private int $taskId;

	/**
	 * @var int $createdBy
	 */
	private int $createdBy;

	/**
	 * @var string $createdAt
	 */
	private string $createdAt;

	/**
	 * @var string $comment
	 */
	private string $comment;

	/**
	 * Constructor function
	 * 
	 * @param int $taskId
	 * @param string $comment
	 * 
	 * @return static
	 */
	public function __construct(int $taskId, string $comment)
	{
		$this->taskId = $taskId;
		$this->createdBy = unserialize($_SESSION['user'])->getId();
		$this->createdAt = date("Y-m-d");
		$this->comment = $comment;
	}

	/**
	 * TaskId getter
	 * 
	 * @return int
	 */
	public function getTaskId(): int
	{
		return $this->taskId;
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
	 * CreatedAt getter
	 * 
	 * @return string
	 */
	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	/**
	 * Comment getter
	 * 
	 * @return string
	 */
	public function getComment(): string
	{
		return $this->comment;
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
		return new self((int)$json->taskId, $json->comment);
	}
}

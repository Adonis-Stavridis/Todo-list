<?php

declare(strict_types=1);

namespace Todo\Models;

use JsonSerializable;

class Comment implements JsonSerializable
{
	private string $createdBy;
	private string $createdAt;
	private string $comment;

	public function __construct(string $createdBy, string $createdAt, string $comment)
	{
		$this->createdBy = $createdBy;
		$this->createdAt = $createdAt;
		$this->comment = $comment;
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

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}

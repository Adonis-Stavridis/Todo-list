<?php

declare(strict_types=1);

namespace Todo\Models;

use JsonSerializable;

class Comment implements JsonSerializable
{
	private string $createdBy;
	private string $createdAt;
	private string $content;

	public function __construct(string $createdBy, string $createdAt, string $content)
	{
		$this->createdBy = $createdBy;
		$this->createdAt = $createdAt;
		$this->content = $content;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}

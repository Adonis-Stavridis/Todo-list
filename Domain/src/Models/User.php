<?php

declare(strict_types=1);

namespace TodoDomain\Models;

use JsonSerializable;

class User implements JsonSerializable
{
	private int $id;
	private string $username;

	public function __construct(int $id, string $username)
	{
		$this->id = $id;
		$this->username = $username;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}

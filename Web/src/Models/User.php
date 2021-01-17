<?php

declare(strict_types=1);

namespace TodoWeb\Models;

use stdClass;

class User
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

	public static function from(stdClass $json)
	{
		return new self($json->id, $json->username);
	}
}
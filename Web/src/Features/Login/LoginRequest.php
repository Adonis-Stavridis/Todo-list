<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use JsonSerializable;
use stdClass;

class LoginRequest implements JsonSerializable
{
	private string $username;
	private string $password;

	public function __construct(string $username, string $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public static function from(stdClass $json)
	{
		return new self($json->username, $json->password);
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}
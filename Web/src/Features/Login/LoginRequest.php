<?php

declare(strict_types=1);

namespace Todo\Features\Login;

use stdClass;

class LoginRequest
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
}

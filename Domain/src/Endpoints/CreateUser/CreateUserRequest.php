<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\CreateUser;

use stdClass;

class CreateUserRequest
{
	private string $username;
	private string $password;
	private string $passwordRepeat;

	public function __construct(string $username, string $password, string $passwordRepeat)
	{
		$this->username = $username;
		$this->password = $password;
		$this->passwordRepeat = $passwordRepeat;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getPasswordRepeat()
	{
		return $this->passwordRepeat;
	}

	public static function from(stdClass $json)
	{
		return new self($json->username, $json->password, $json->passwordRepeat);
	}
}

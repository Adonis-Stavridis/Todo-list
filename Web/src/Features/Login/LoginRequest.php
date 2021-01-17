<?php

declare(strict_types=1);

namespace TodoWeb\Features\Login;

use JsonSerializable;
use stdClass;

class LoginRequest implements JsonSerializable
{
	/**
	 * @var string $username
	 */
	private string $username;

	/**
	 * @var string $password
	 */
	private string $password;

	/**
	 * Constructor function
	 * 
	 * @param string $username
	 * @param string $password
	 * 
	 * @return static
	 */
	public function __construct(string $username, string $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Username getter
	 * 
	 * @return string
	 */
	public function getUsername(): string
	{
		return $this->username;
	}

	/**
	 * Password getter
	 * 
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
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
		return new self($json->username, $json->password);
	}

	/**
	 * Json serialize function
	 * 
	 * @return array
	 */
	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}

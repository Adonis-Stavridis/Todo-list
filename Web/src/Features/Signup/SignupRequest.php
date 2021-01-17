<?php

declare(strict_types=1);

namespace TodoWeb\Features\Signup;

use stdClass;

class SignupRequest
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
	 * @var string $passwordRepeat
	 */
	private string $passwordRepeat;

	/**
	 * Constructor function
	 * 
	 * @param string $username
	 * @param string $password
	 * @param string $passwordRepeat
	 * 
	 * @return static
	 */
	public function __construct(string $username, string $password, string $passwordRepeat)
	{
		$this->username = $username;
		$this->password = $password;
		$this->passwordRepeat = $passwordRepeat;
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
	 * PasswordRepeat getter
	 * 
	 * @return string
	 */
	public function getPasswordRepeat(): string
	{
		return $this->passwordRepeat;
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
		return new self($json->username, $json->password, $json->passwordRepeat);
	}
}

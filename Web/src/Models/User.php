<?php

declare(strict_types=1);

namespace TodoWeb\Models;

class User
{
	/**
	 * @var int $id
	 */
	private int $id;

	/**
	 * @var string $username
	 */
	private string $username;

	/**
	 * Constructor function
	 * 
	 * @param int $id
	 * @param string $username
	 * 
	 * @return static
	 */
	public function __construct(int $id, string $username)
	{
		$this->id = $id;
		$this->username = $username;
	}

	/**
	 * Id getter
	 * 
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
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
}

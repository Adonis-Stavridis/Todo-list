<?php

declare(strict_types=1);

namespace TodoWeb\Models;

class Comment
{
	/**
	 * @var string $createdBy
	 */
	private string $createdBy;

	/**
	 * @var string $createdAt
	 */
	private string $createdAt;

	/**
	 * @var string $comment
	 */
	private string $comment;

	/**
	 * Constructor function
	 * 
	 * @param string $createdBy
	 * @param string $createdAt
	 * @param string $comment
	 * 
	 * @return static
	 */
	public function __construct(string $createdBy, string $createdAt, string $comment)
	{
		$this->createdBy = $createdBy;
		$this->createdAt = $createdAt;
		$this->comment = $comment;
	}

	/**
	 * CreatedBy getter
	 * 
	 * @return string
	 */
	public function getCreatedBy(): string
	{
		return $this->createdBy;
	}

	/**
	 * CreatedAt getter
	 * 
	 * @return string
	 */
	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	/**
	 * Comment getter
	 * 
	 * @return string
	 */
	public function getComment(): string
	{
		return $this->comment;
	}
}

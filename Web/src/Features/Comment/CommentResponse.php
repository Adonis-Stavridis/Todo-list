<?php

declare(strict_types=1);

namespace TodoWeb\Features\Comment;

use TodoWeb\Models\Comment;

class CommentResponse
{
	/**
	 * @var Comment $comment
	 */
	private Comment $comment;

	/**
	 * Constructor function
	 * 
	 * @param Comment $comment
	 * 
	 * @return static
	 */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * Comment getter
	 * 
	 * @return Comment
	 */
	public function getComment(): Comment
	{
		return $this->comment;
	}
}

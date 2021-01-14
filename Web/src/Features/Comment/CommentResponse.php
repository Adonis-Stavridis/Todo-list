<?php

declare(strict_types=1);

namespace TodoWeb\Features\Comment;

use TodoWeb\Models\Comment;

class CommentResponse
{
	private Comment $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

	public function getComment(): Comment
	{
		return $this->comment;
	}
}

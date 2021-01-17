<?php

declare(strict_types=1);

namespace TodoDomain\Repositories;

interface TaskRepository
{
	public function getAll(): array;
}

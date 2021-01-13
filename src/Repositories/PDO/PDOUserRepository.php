<?php

declare(strict_types=1);

namespace Todo\Repositories\PDO;

use PDO;
use Todo\Features\Signup\SignupRequest;
use Todo\Models\User;
use Todo\Repositories\UserRepository;

class PDOUserRepository implements UserRepository
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getAll(): array
	{
		$query = 'SELECT id,username FROM users';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$res = $stmt->fetchAll();

		$users = [];
		foreach ($res as $key) {
			$users[] = new User((int)$key['id'], $key['username']);
		}

		return $users;
	}

	public function getUser(string $username): array
	{
		$query = 'SELECT id, password FROM users WHERE username = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$username]);
		$res = $stmt->fetch();

		return array(
			'user' => new User((int)$res['id'], $username),
			'password' => $res['password']
		);
	}

	public function userExists(string $username): bool
	{
		$query = 'SELECT 1 FROM users WHERE username = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$username]);
		$res = $stmt->fetch();

		return $res ? true : false;
	}

	public function addUser(SignupRequest $signup): bool
	{
		$query = 'INSERT INTO users (username, password) VALUES ( ? , ? )';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([
			$signup->getUsername(),
			password_hash($signup->getPassword(), PASSWORD_BCRYPT)
		]);

		return $this->pdo->lastInsertId() ? true : false;
	}
}

<?php

declare(strict_types=1);

namespace TodoWeb\Repositories\PDO;

use PDO;
use TodoWeb\Features\Login\LoginRequest;
use TodoWeb\Features\Signup\SignupRequest;
use TodoWeb\Models\User;
use TodoWeb\Repositories\UserRepository;

class PDOUserRepository implements UserRepository
{
	/**
	 * @var PDO $pdo
	 */
	private PDO $pdo;

	/**
	 * Constructor function
	 * 
	 * @param PDO $pdo
	 * 
	 * @return static
	 */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	/**
	 * Get user
	 * 
	 * @param LoginRequest $request
	 * 
	 * @return mixed
	 */
	public function getUser(LoginRequest $request): ?array
	{
		$query = 'SELECT id, password FROM users WHERE username = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$request->getUsername()]);
		$res = $stmt->fetch();

		if (!$res) {
			return null;
		}

		return array(
			'user' => new User((int)$res['id'], $request->getUsername()),
			'password' => $res['password']
		);
	}

	/**
	 * Get all users
	 * 
	 * @return array
	 */
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

	/**
	 * Check if user exists
	 * 
	 * @param string $username
	 * 
	 * @return bool
	 */
	public function userExists(string $username): bool
	{
		$query = 'SELECT 1 FROM users WHERE username = ?';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute([$username]);
		$res = $stmt->fetch();

		return $res ? true : false;
	}

	/**
	 * Add user
	 * 
	 * @param SignupRequest $signup
	 * 
	 * @return bool
	 */
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

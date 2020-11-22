<?php
declare(strict_types=1);

namespace Todo\Models;

class User extends Model {
  /**
   * Get user id if password is correct.
   * 
   * @param string $username
   * @param string $password
   * 
   * @return int
   */
  protected function userLogin(string $username, string $password): int {
    $query = 'SELECT id, password FROM users WHERE username = ?';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$username]);
    $res = $stmt->fetch();
    
    if (!$res) {
      return -1;
    }

    if (!password_verify($password, $res['password'])) {
      return -1;
    }

    return (int)$res['id'];
  }

  /**
   * Check if user exists.
   * 
   * @param string $username
   * 
   * @return bool
   */
  protected function userExists(string $username): bool {
    $query = 'SELECT 1 FROM users WHERE username = ?';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$username]);
    $res = $stmt->fetch();
    
    if (!$res) {
      return false;
    }

    return true;
  }

  /**
   * Add user with hashed password.
   * 
   * @param string $username
   * @param string $password
   * 
   * @return void
   */
  protected function addUser(string $username, string $password): void {
    $query = 'INSERT INTO users (username, password) VALUES ( ? , ? )';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT)]);
  }
}

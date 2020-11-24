<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Todo\Models\User;

class UserTest extends TestCase {
  /**
   * @var $usersTableSample
   */
  private static array $usersTableSample = [
    'root' => ['root',1]
  ];

  /**
   * Test userLogin
   */
  public function testUserLogin() {
    $user = $this->createMock(User::class);

    $user->method('userLogin')->will($this->returnCallback(
      function (string $username, string $password) {
        if (array_key_exists($username, self::$usersTableSample)) {
          if (self::$usersTableSample[$username][0] == $password) {
            return self::$usersTableSample[$username][1];
          }
        }
        return -1;
      }
    ));

    $this->assertEquals(1, $user->userLogin('root','root'));
    $this->assertEquals(-1, $user->userLogin('root','fake'));
    $this->assertEquals(-1, $user->userLogin('fake','fake'));
  }

  /**
   * Test userExists
   */
  public function testUserExists() {
    $user = $this->createMock(User::class);

    $user->method('userExists')->will($this->returnCallback(
      function (string $username) {
        return array_key_exists($username, self::$usersTableSample);
      }
    ));

    $this->assertTrue($user->userExists('root'));
    $this->assertFalse($user->userExists('fake'));
  }

  /**
   * Test addUser
   */
  public function testAddUser() {
    $user = $this->createMock(User::class);

    $user->expects($this->once())->method('addUser')->will($this->returnCallback(
      function (string $username, string $password) {
        $newUserId = count(self::$usersTableSample) + 1;
        array_push(self::$usersTableSample, $username);
        self::$usersTableSample[$username] = [$password, $newUserId];
        return $newUserId;
      }
    ));

    $this->assertEquals(2, $user->addUser('adonis','adonis'));
  }
}

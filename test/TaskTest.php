<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Todo\Models\Task;

class TaskTest extends TestCase {
  /**
   * @var $todosTableSample
   */
  private static array $todosTableSample = [
    1 => [2,2,'Learn PHP','Learn the Web Dev class content','2020-09-05','2020-10-25']
  ];

  /**
   * @var $usersTableSample
   */
  private static array $usersTableSample = [[1,'root','root'], [2,'adonis','adonis']];

  /**
   * @var $commentsTableSample
   */
  private static array $commentsTableSample = [
    [1,1,2,'2020-09-10','Study also for the exam!']
  ];

  /**
   * Test getTaskInfo
   */
  public function testGetTaskInfo() {
    $task = $this->createMock(Task::class);

    $task->method('getTaskInfo')->will($this->returnCallback(
      function (int $taskId) {
        if (array_key_exists($taskId, self::$todosTableSample)) {
          return array_merge([$taskId], self::$todosTableSample[$taskId]);
        }
        return [];
      }
    ));

    $expected = [1,2,2,'Learn PHP','Learn the Web Dev class content','2020-09-05','2020-10-25'];
    $this->assertEquals($expected, $task->getTaskInfo(1));
    $this->assertEmpty($task->getTaskInfo(2));
  }

  /**
   * Test getAllTasks
   */
  public function testGetAllTasks() {
    $task = $this->createMock(Task::class);

    $task->method('getAllTasks')->will($this->returnCallback(
      function () {
        $res = [];
        foreach(self::$todosTableSample as $key => $value) {
          array_push($res, array_merge([$key], $value));
        }
        return $res;
      }
    ));

    $expected = [[1,2,2,'Learn PHP','Learn the Web Dev class content','2020-09-05','2020-10-25']];
    $this->assertEquals($expected, $task->getAllTasks());
  }

  /**
   * Test addTask
   */
  public function testAddTask() {
    $task = $this->createMock(Task::class);

    $task->expects($this->once())->method('addTask')->will($this->returnCallback(
      function (int $createdBy, int $assignTo, string $title, string $description, string $createdAt, string $dueDate) {
        $newTaskId = max(array_keys(self::$todosTableSample)) + 1;
        array_push(self::$todosTableSample, $newTaskId);
        self::$todosTableSample[$newTaskId] = [2,3,'Learn the Slim Framework','Read the Slim documentation','2020-10-25','2020-10-31'];
        return $newTaskId;
      }
    ));

    $this->assertEquals(2, $task->addTask(2,3,'Learn the Slim Framework','Read the Slim documentation','2020-10-25','2020-10-31'));
  }

  /**
   * Test getAllUsers
   */
  public function testGetAllUsers() {
    $task = $this->createMock(Task::class);

    $task->method('getAllUsers')->will($this->returnCallback(
      function () {
        $res = [];
        foreach(self::$usersTableSample as $user) {
          array_push($res, [$user[0], $user[1]]);
        }
        return $res;
      }
    ));

    $this->assertEquals([[1,'root'],[2,'adonis']], $task->getAllUsers());
  }

  public function testAddCommentToTask() {
    $task = $this->createMock(Task::class);

    $task->expects($this->once())->method('addCommentToTask')->will($this->returnCallback(
      function (int $taskId, int $createdBy, string $createdAt, string $comment) {
        $newCommentId = count(self::$commentsTableSample) + 1;
        array_push(self::$commentsTableSample, [$newCommentId, $taskId, $createdBy,$createdAt, $comment]);
        return $newCommentId;
      }
    ));

    $this->assertEquals(2, $task->addCommentToTask(1,3,'2020-09-18','Yeah! I should do that too...'));
  }

  /**
   * Test getCommentsByTask
   */
  public function testGetCommentsByTask() {
    $task = $this->createMock(Task::class);

    $task->method('getCommentsByTask')->will($this->returnCallback(
      function (int $taskId) {
        $res = [];
        foreach(self::$commentsTableSample as $comment) {
          if ($comment[1] == $taskId) {
            array_push($res, [$comment[2], $comment[3], $comment[4]]);
          }
        }
        return $res;
      }
    ));

    $this->assertEquals([[2,'2020-09-10','Study also for the exam!'], [3,'2020-09-18','Yeah! I should do that too...']], $task->getCommentsByTask(1));
  }
}

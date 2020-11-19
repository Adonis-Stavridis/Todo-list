<?php
declare(strict_types=1);

namespace Todo\Models;

use DI\Container;
use PDO;

class Model {
  protected PDO $db;

  public function __construct(Container $container) {
    $this->db = $container->get('db');
  }
}

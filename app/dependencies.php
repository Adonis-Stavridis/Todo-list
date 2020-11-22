<?php
declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use Slim\Views\Twig;

/**
 * Builds a container with all dependencies.
 *
 * Set a 'db' field inside the container to access a PDO instance to connect to
 * a database. Sets a 'view' field to access Twig views. Returns the built 
 * container.
 *
 * @return Container
 */
return function (): Container {
  $containerBuilder = new ContainerBuilder();

  $containerBuilder->addDefinitions([
    'db' => function () : PDO {
      $host = $_ENV['DB_HOST'];
      $port = $_ENV['DB_PORT'];
      $name = $_ENV['DB_NAME'];
      $user = $_ENV['DB_USER'];
      $pass = $_ENV['DB_PASS'];
      $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8;";

      try {
        $pdo = new PDO($dsn, $user, $pass, [ PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]);
        return $pdo;
      } catch (PDOException $e) {
        echo '<h1>Connection failed!</h1><p>'.$e->getMessage().'</p><p><strong>Try again later!</strong></p>';
        die();
      }
    },
    'view' => function () : Twig {
      $path = $_ENV['VIEWS_PATH'];
      $view = Twig::create(__DIR__ . $path, [ "cache" => false ]);
      return $view;
    }
  ]);

  return $containerBuilder->build();
};

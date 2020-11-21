<?php
declare(strict_types=1);

use DI\Container;

return function (Container $container): void {
  $container->set('settings', \DI\value([
    'displayErrorDetails' => true,
    'logErrorDetails' => true,
    'logErrors' => true
  ]));
};

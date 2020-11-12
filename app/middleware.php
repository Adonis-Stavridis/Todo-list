<?php
declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Todo\Controllers\_404Controller;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\TwigMiddleware;

return function (App $app) {
  $settings = $app->getContainer()->get('settings');
  
  $errorMiddleware = $app->addErrorMiddleware(
    $settings['displayErrorDetails'],
    $settings['logErrorDetails'],
    $settings['logErrors']
  );

  $customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails
  ) use ($app) {
    $response = (new Response())->withStatus(404);
    $container = $app->getContainer();
    $_404Controller = new _404Controller($container);
    return $_404Controller->get404($request,$response);
  };
  
  $errorMiddleware->setErrorHandler(HttpNotFoundException::class, $customErrorHandler);
  
  $app->add(TwigMiddleware::createFromContainer($app));
};

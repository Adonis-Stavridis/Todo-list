<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use TodoWeb\Features\Render404Page\Render404PageController;

/**
 * Creates middleware to handle errors.
 * 
 * Handle proper display of errors and 404 response status.
 * 
 * @param App $app
 *
 * @return void
 */
return function (App $app): void {
	$app->addRoutingMiddleware();

	$errorMiddleware = $app->addErrorMiddleware(true, true, true);

	$customErrorHandler = function (
		ServerRequestInterface $request,
		Throwable $exception,
		bool $displayErrorDetails,
		bool $logErrors,
		bool $logErrorDetails
	) use ($app) {
		$response = $app->getResponseFactory()->createResponse();
		$view = $app->getContainer()->get(Twig::class);
		$render404PageController = new Render404PageController($view);
		return $render404PageController($request, $response);
	};

	$errorMiddleware->setErrorHandler(HttpNotFoundException::class, $customErrorHandler);

	$app->add(TwigMiddleware::createFromContainer($app, Twig::class));
};

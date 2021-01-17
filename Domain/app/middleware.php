<?php

declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

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
		$response = $app->getResponseFactory()->createResponse(404);
		return $response;
	};

	$errorMiddleware->setErrorHandler(HttpNotFoundException::class, $customErrorHandler);
};

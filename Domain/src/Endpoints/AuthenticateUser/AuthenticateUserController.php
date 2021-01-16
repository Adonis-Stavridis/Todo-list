<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\AuthenticateUser;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthenticateUserController
{
	private AuthenticateUserService $service;

	public function __construct(AuthenticateUserService $service)
	{
		$this->service = $service;
	}

	public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		try {
			$body = json_decode($request->getBody()->__toString());
			$businessRequest = AuthenticateUserRequest::from($body);
			$businessResponse = $this->service->handle($businessRequest);

			$response->withStatus(200);
			$response->getBody()->write(json_encode($businessResponse->getUser()->jsonSerialize()));
			return $response;
		} catch (Exception $exception) {
			$response->withStatus($exception->getCode());
			$response->getBody()->write($exception->getMessage());
			return $response;
		}
	}
}

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
			parse_str($request->getUri()->getQuery(), $query);
			$body = json_decode(json_encode($query));
			$businessRequest = AuthenticateUserRequest::from($body);
			$businessResponse = $this->service->handle($businessRequest);

			$response->getBody()->write(json_encode($businessResponse->getUser()->jsonSerialize()));
			return $response->withStatus(200);
		} catch (Exception $exception) {
			$response->getBody()->write($exception->getMessage());
			return $response->withStatus($exception->getCode());
		}
	}
}

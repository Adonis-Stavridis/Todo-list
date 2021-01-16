<?php

declare(strict_types=1);

namespace TodoWeb\Repositories\Api;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use TodoWeb\Features\Login\LoginRequest;
use TodoWeb\Features\Signup\SignupRequest;
use TodoWeb\Models\User;
use TodoWeb\Repositories\UserRepository;

class ApiUserRepository implements UserRepository
{
	private ClientInterface $httpClient;
	private RequestFactoryInterface $requestFactory;
	private StreamFactoryInterface $streamFactory;
	private string $apiEndpoint;

	public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, string $apiEndpoint)
	{
		$this->httpClient = $httpClient;
		$this->requestFactory = $requestFactory;
		$this->streamFactory = $streamFactory;
		$this->apiEndpoint = $apiEndpoint;
	}

	public function getUser(LoginRequest $request): ?User
	{

		$apiRequest = $this->requestFactory->createRequest('POST', $this->apiEndpoint . '/users/' . $request->getUsername());
		$apiRequest->getBody()->write(json_encode($request->jsonSerialize()));

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return null;
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		return User::from($jsonResponse);
	}

	public function getAll(): array
	{
		$apiRequest = $this->requestFactory->createRequest('GET', $this->apiEndpoint . '/users');

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		$users = [];
		foreach ($jsonResponse as $key) {
			$users[] = new User((int)$key->userId, $key->username);
		}

		return $users;
	}

	public function addUser(SignupRequest $signup): bool
	{
		$apiRequest = $this->requestFactory->createRequest('POST', $this->apiEndpoint . '/users');
		$apiRequest->withBody($this->streamFactory->createStream(json_encode($signup)));

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 201) {
			return false;
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		return $jsonResponse->inserted;
	}

	public function userExists(string $username): bool
	{
		$apiRequest = $this->requestFactory->createRequest('GET', $this->apiEndpoint . '/users/' . $username);

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return false;
		}

		return true;
	}
}

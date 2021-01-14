<?php

declare(strict_types=1);

namespace TodoWeb\Repositories\Api;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use TodoWeb\Features\Comment\CommentRequest;
use TodoWeb\Features\CreateTask\CreateTaskRequest;
use TodoWeb\Models\Comment;
use TodoWeb\Models\Task;
use TodoWeb\Repositories\TaskRepository;

class ApiTaskRepository implements TaskRepository
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

	public function getTask(int $taskId): Task
	{
		$apiRequest = $this->requestFactory->createRequest('GET', $this->apiEndpoint . '/tasks/' . $taskId);

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		return new Task(
			$jsonResponse->taskId,
			$jsonResponse->createdBy,
			$jsonResponse->assignedTo,
			$jsonResponse->title,
			$jsonResponse->description,
			$jsonResponse->createdAt,
			$jsonResponse->dueDate
		);
	}

	public function getAll(): array
	{
		$apiRequest = $this->requestFactory->createRequest('GET', $this->apiEndpoint . '/tasks');

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		$tasks = [];
		foreach ($jsonResponse->tasks as $key) {
			$tasks[] = new Task(
				$key->taskId,
				$key->createdBy,
				$key->assignedTo,
				$key->title,
				$key->description,
				$key->createdAt,
				$key->dueDate
			);
		}

		return $tasks;
	}

	public function addTask(CreateTaskRequest $task): int
	{
		$apiRequest = $this->requestFactory->createRequest('POST', $this->apiEndpoint . '/tasks');
		$apiRequest->withBody($this->streamFactory->createStream(json_encode($task)));

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 201) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		return $jsonResponse->taskId;
	}

	public function getTaskComments(int $taskId): array
	{
		$apiRequest = $this->requestFactory->createRequest('GET', $this->apiEndpoint . '/tasks/' . $taskId . '/comments');

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		$comments = [];
		foreach ($jsonResponse->comments as $key) {
			$comments[] = new Comment(
				$key->createdBy,
				$key->createdAt,
				$key->comment
			);
		}

		return $comments;
	}

	public function addTaskComment(CommentRequest $comment): Comment
	{
		$apiRequest = $this->requestFactory->createRequest('POST', $this->apiEndpoint . '/tasks/' . $comment->getTaskId() . '/comments');
		$apiRequest->withBody($this->streamFactory->createStream(json_encode($comment)));

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 201) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		return new Comment(
			$jsonResponse->createdBy,
			$comment->getCreatedAt(),
			$comment->getComment()
		);
	}
}

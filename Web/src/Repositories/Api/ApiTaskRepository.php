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
use TodoWeb\Repositories\ApiRepository;

class ApiTaskRepository implements ApiRepository
{
	/**
	 * @var ClientInterface $httpClient
	 */
	private ClientInterface $httpClient;

	/**
	 * @var RequestFactoryInterface $requestFactory
	 */
	private RequestFactoryInterface $requestFactory;

	/**
	 * @var StreamFactoryInterface $streamFactory
	 */
	private StreamFactoryInterface $streamFactory;

	/**
	 * @var string $apiEndpoint
	 */
	private string $apiEndpoint;

	/**
	 * Constructor function
	 * 
	 * @param ClientInterface $httpClient
	 * @param RequestFactoryInterface $requestFactory
	 * @param StreamFactoryInterface $streamFactory
	 * @param string $apiEndpoint
	 * 
	 * @return static
	 */
	public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, string $apiEndpoint)
	{
		$this->httpClient = $httpClient;
		$this->requestFactory = $requestFactory;
		$this->streamFactory = $streamFactory;
		$this->apiEndpoint = $apiEndpoint;
	}

	/**
	 * Get a task
	 * 
	 * @param int $taskId
	 * 
	 * @return Task
	 */
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

	/**
	 * Get all tasks
	 * 
	 * @return array
	 */
	public function getAll(): array
	{
		$apiRequest = $this->requestFactory->createRequest('GET', $this->apiEndpoint . '/tasks');

		$apiResponse = $this->httpClient->sendRequest($apiRequest);

		if ($apiResponse->getStatusCode() !== 200) {
			return [];
		}

		$jsonResponse = json_decode($apiResponse->getBody()->__toString());

		$tasks = [];
		foreach ($jsonResponse as $key) {
			$tasks[] = array(
				'id' => $key->id,
				'createdBy' => $key->createdBy,
				'assignedTo' => $key->assignedTo,
				'title' => $key->title
			);
		}

		return $tasks;
	}

	/**
	 * Add a task
	 * 
	 * @param CreateTaskRequest $task
	 * 
	 * @return int
	 */
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

	/**
	 * Get task comments
	 * 
	 * @param int $taskId
	 * 
	 * @return array
	 */
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

	/**
	 * Add comment to task
	 * 
	 * @param CommentRequest $comment
	 * 
	 * @return Comment
	 */
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

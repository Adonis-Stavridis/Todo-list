<?php

declare(strict_types=1);

namespace TodoDomain\Endpoints\Information;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class InformationController
{
	/**
	 * Invoke function handle request and send response
	 * 
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * 
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		$information = array(
			'title' => 'Todo-list API',
			'authors' => ['Adonis Stavridis', 'Mika Filleul']
		);

		$jsonResponse = json_encode($information);
		$response->getBody()->write($jsonResponse);

		return $response;
	}
}

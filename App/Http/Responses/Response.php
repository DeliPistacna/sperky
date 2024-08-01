<?php

namespace Sperky\App\Http\Responses;

use Sperky\App\Interfaces\ResponseInterface;

abstract class Response implements ResponseInterface
{
	public bool $status;
	public mixed $response;
	protected int $httpStatusCode;
	
	
	public function __construct(mixed $response = '', bool $status = true, int $httpStatusCode = 200)
	{
		$this->setResponse($response);
		$this->setResponseStatus($status);
		$this->setHttpStatusCode($httpStatusCode);
	}
	
	
	public function setResponseStatus(bool $status): void
	{
		$this->status = $status;
	}
	
	
	public function setResponse(mixed $response): void
	{
		$this->response = $response;
	}
	
	
	public function setHttpStatusCode(int $httpStatusCode): void
	{
		$this->httpStatusCode = $httpStatusCode;
	}
	
	
	public function getResponse(): array
	{
		return [
			'httpCode' => $this->httpStatusCode,
			'headers' => [
			],
			'body' => $this->response,
		];
	}
	
	
	public function send(): void
	{
		print_r($this->getResponse());
		die();
	}
}
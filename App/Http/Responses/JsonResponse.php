<?php

namespace Sperky\App\Http\Responses;


class JsonResponse extends Response
{
	/**
	 * Returns JSON String from response
	 *
	 * @return string
	 */
	public function toJson(): string
	{
		return json_encode([
			'success' => $this->status,
			'response' => $this->response,
		]);
	}
	
	
	public function getResponse(): array
	{
		return [
			'httpCode' => $this->httpStatusCode,
			'headers' => [
				'Content-Type' => 'application/json; charset=utf-8'
			],
			'body' => $this->toJson()
		];
	}
	
	
	/**
	 * Returns application/json http response and dies
	 *
	 * @return void
	 */
	public function send(): void
	{
		$response = $this->getResponse();
		http_response_code($response['httpCode']);
		foreach ( $response['headers'] as $header => $value ) {
			header("$header: $value");
		}
		echo $response['body'];
		die();
	}
}
<?php

namespace Sperky\App\Http\Responses;


use LogicException;

class FailedJsonResponse extends JsonResponse
{
	
	/**
	 * Create JsonResponse with status FALSE
	 *
	 * @param mixed $response
	 * @param int   $httpStatusCode
	 */
	public function __construct(mixed $response = '', int $httpStatusCode = 400)
	{
		parent::__construct($response, false, $httpStatusCode);
		$this->status = false;
	}
	
	
	/**
	 * Prevent changing the status for FailedJsonResponse
	 *
	 * @param bool $status
	 */
	public function setResponseStatus(bool $status): void
	{
	}
	
}
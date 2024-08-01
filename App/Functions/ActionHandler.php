<?php

namespace Sperky\App\Functions;

use Sperky\App\Functions\ActionStrategies\ActionStrategyFactory;
use Sperky\App\Http\Responses\FailedJsonResponse;
use Sperky\App\Enums\ActionsEnum;
use Sperky\App\Http\Responses\Response;
use Sperky\App\Interfaces\ResponseInterface;
use Throwable;

class ActionHandler
{
	protected ?ActionsEnum $action = null;
	
	
	public function __construct(
		protected ActionStrategyFactory $factory
	)
	{
	}
	
	
	/**
	 * Handles action by name and returns response.
	 * Checks if ActionEnum exists for this action, if yes then
	 * proceeds to execution of ActionStrategy
	 *
	 * In case of failure, Response with error message and "success":false is provided
	 *
	 * @param string|null $actionName
	 * @param string|null $data
	 *
	 * @return Response
	 */
	public function handle(?string $actionName, ?string $data = ''): ResponseInterface
	{
		
		// Set the action enum or return bad response
		if ( !$this->setActionEnum($actionName) ) {
			return $this->fail("Invalid action specified", 400);
		}
		
		try {
			return $this->runActionStrategy($data); // Returns response
		} catch ( Throwable ) {
			// Ignoring $exception->message in case failed strategy throws anything sensitive
			// Maybe add logger later
			return self::fail("Failed to execute action strategy", 500);
		}
	}
	
	
	/**
	 * Sets the ActionEnum property if valid, otherwise returns false.
	 *
	 * @param string|null $actionName
	 *
	 * @return bool
	 */
	private function setActionEnum(?string $actionName): bool
	{
		$this->action = ActionsEnum::tryFrom($actionName);
		return $this->action !== null;
	}
	
	
	/**
	 * Returns failed JsonResponse with provided message and status code, default 200
	 * Used only for consistency
	 *
	 * @param string $message
	 * @param int    $status
	 *
	 * @return Response
	 */
	private static function fail(string $message = "Unknown error", int $status = 400): ResponseInterface
	{
		return new FailedJsonResponse($message, $status);
	}
	
	
	/**
	 * Calls execute method on ActionStrategy for provided ActionEnum
	 *
	 * @param string|null $data
	 *
	 * @return Response
	 */
	private function runActionStrategy(?string $data): ResponseInterface
	{
		$strategy = $this->factory::getStrategy($this->action);
		return $strategy->execute($data);
	}
}
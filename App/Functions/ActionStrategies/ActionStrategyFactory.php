<?php

namespace Sperky\App\Functions\ActionStrategies;

use InvalidArgumentException;
use Sperky\App\Enums\ActionsEnum;
use Sperky\App\Interfaces\ActionStrategyInterface;


class ActionStrategyFactory
{
	
	/**
	 * Get strategy based on ActionEnum
	 * When expanding this don't forget to add both enum and strategy for new actions
	 *
	 * @param ActionsEnum $action
	 *
	 * @return ActionStrategyInterface
	 * @throws InvalidArgumentException when unsupported action is passed
	 */
	public static function getStrategy(ActionsEnum $action): ActionStrategyInterface
	{
		return match ( $action ) {
			// Add Strategies here
			ActionsEnum::DO_NOTHING => new DoNothingStrategy(),
			
			ActionsEnum::GET_WAREHOUSE_VALUE => new GetWarehouseValueStrategy(),
			default => throw new InvalidArgumentException('Unknown action: ' . $action->value),
		};
	}
}
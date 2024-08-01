<?php

namespace Sperky\App\Functions\ActionStrategies;

use Sperky\App\Http\Responses\JsonResponse;
use Sperky\App\Http\Responses\Response;
use Sperky\App\Interfaces\ActionStrategyInterface;
use Sperky\App\Interfaces\ResponseInterface;
use Sperky\App\Models\Product;

class GetWarehouseValueStrategy implements ActionStrategyInterface
{
	/**
	 * @param string|null $data - Unused in this strategy
	 *
	 * @return ResponseInterface
	 */
	public function execute(?string $data): ResponseInterface
	{
		$value = Product::getWarehouseValue();
		return new JsonResponse($value);
	}
}
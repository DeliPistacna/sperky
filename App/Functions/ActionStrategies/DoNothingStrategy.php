<?php

namespace Sperky\App\Functions\ActionStrategies;

use Sperky\App\Http\Responses\JsonResponse;
use Sperky\App\Interfaces\ActionStrategyInterface;
use Sperky\App\Interfaces\ResponseInterface;

class DoNothingStrategy implements ActionStrategyInterface
{
	
	public function execute(?string $data): ResponseInterface
	{
		return new JsonResponse('Did nothing');
	}
}
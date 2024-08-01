<?php

namespace Sperky\App\Interfaces;

interface ActionStrategyInterface
{
	public function execute(?string $data): ResponseInterface;
}
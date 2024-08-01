<?php

namespace Sperky\App\Interfaces;

interface ResponseInterface
{
	
	/**
	 * Return response data as an array
	 *
	 * @return array
	 */
	public function getResponse(): array;
	
	
	/**
	 * Send HTTP response and die
	 *
	 * @return void
	 */
	public function send(): void;
}
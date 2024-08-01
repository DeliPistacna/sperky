<?php

namespace Sperky\App\Database;

class Row
{
	public function __construct(
		protected array $data
	)
	{
	}
	
	
	/**
	 * Get internal data array
	 *
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}
	
	
	/**
	 * Set row parameter
	 *
	 * @param string $name
	 * @param        $value
	 *
	 * @return void
	 */
	public function __set(string $name, $value): void
	{
		$this->data[ $name ] = $value;
	}
	
	
	/**
	 * Get row parameter
	 *
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public function __get($name)
	{
		return $this->data[ $name ] ?? null;
	}
	
	
	/**
	 * Check if internal data array contains key
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->data[ $name ]);
	}
}
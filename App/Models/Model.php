<?php

namespace Sperky\App\Models;

use InvalidArgumentException;
use Sperky\App\Repositories\Repository;
use RuntimeException;

abstract class Model
{
	
	public const array REQUIRED_KEYS = [];
	
	// Store repository instances per model class
	protected static array $repositories = [];
	
	
	/**
	 * Initialize the repository for the model.
	 * This method should be called to ensure the repository is set up.
	 */
	protected static function initializeRepository(): void
	{
		if ( !isset(self::$repositories[ static::class ]) ) {
			self::$repositories[ static::class ] = static::createRepository();
		}
	}
	
	
	/**
	 * Get the repository for the current model.
	 * This method must be implemented in subclasses.
	 *
	 * @return Repository
	 */
	abstract protected static function createRepository(): Repository;
	
	
	/**
	 * Get the repository instance for the model.
	 * Ensures that the repository is initialized before returning it.
	 *
	 * @return Repository
	 * @throws RuntimeException if the repository is not initialized
	 */
	protected static function getRepository(): Repository
	{
		static::initializeRepository();
		if ( !isset(self::$repositories[ static::class ]) ) {
			throw new RuntimeException('Repository not initialized for ' . static::class);
		}
		return self::$repositories[ static::class ];
	}
	
	protected static function validate($data)
	{
		$missingKeys = array_diff(static::REQUIRED_KEYS, array_keys($data));
		if (!empty($missingKeys)) {
			throw new InvalidArgumentException('Invalid product_attribute data: Missing keys - ' . implode(', ', $missingKeys));
		}
	}
}

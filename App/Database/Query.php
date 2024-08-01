<?php

namespace Sperky\App\Database;

use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;


/**
 * SQL PDO Query wrapper using Database class.
 *
 * This class provides a convenient way to execute SQL queries using the PDO extension.
 *
 * Example usage:
 * Query::create("INSERT INTO `contacts` (name) VALUES (:name)")
 *      ->exec([
 *          ':name' => 'test',
 *      ]);
 */
class Query
{
	
	
	private PDO $connection;
	protected PDOStatement $statement;
	
	private function __construct(
		string $statement,
		protected array  $parameters = [],
	)
	{
		$this->connection = Database::getInstance()->getConnection();
		$this->statement = $this->connection->prepare($statement);
	}
	
	
	/**
	 * Create new Query instance
	 *
	 * @param string $statement
	 * @param array  $values
	 *
	 * @return self
	 */
	public static function create(string $statement, array $values = []): self
	{
		return new self($statement, $values);
	}
	
	
	/**
	 * Execute statement and return array of rows
	 *
	 * @param array|null $parametersOverride
	 *
	 * @return array
	 */
	public function getRows(?array $parametersOverride = null): array
	{
		try {
			$this->statement->execute($parametersOverride ?: $this->parameters);
			$results = $this->statement->fetchAll(PDO::FETCH_ASSOC);
			
			return array_map(function ($row) {
				return new Row($row);
			}, $results);
		} catch ( PDOException $e ) {
			throw new RuntimeException('Query failed: ' . $e->getMessage());
		}
	}
	
	
	/**
	 * Execute statement and return array of data (FETCH_ASSOC)
	 *
	 * @param array|null $parametersOverride
	 *
	 * @return array
	 */
	public function getRowsAsArray(?array $parametersOverride = null): array
	{
		try {
			$this->statement->execute($parametersOverride ?: $this->parameters);
			return $this->statement->fetchAll(PDO::FETCH_ASSOC);
		} catch ( PDOException $e ) {
			throw new RuntimeException('Query failed: ' . $e->getMessage());
		}
	}
	
	
	/**
	 * Execute statement and return single row
	 *
	 * @param array|null $parametersOverride
	 *
	 * @return Row
	 */
	public function getRow(?array $parametersOverride = null): Row
	{
		try {
			$this->statement->execute($parametersOverride ?: $this->parameters);
			return new Row($this->statement->fetch(PDO::FETCH_ASSOC));
		} catch ( PDOException $e ) {
			throw new RuntimeException('Query failed: ' . $e->getMessage());
		}
	}
	
	
	/**
	 * Execute statement and return single row (FETCH_ASSOC)
	 *
	 * @param array|null $parametersOverride
	 *
	 * @return Row
	 */
	public function getRowAsArray(?array $parametersOverride = null): Row
	{
		try {
			$this->statement->execute($parametersOverride ?: $this->parameters);
			return $this->statement->fetch(PDO::FETCH_ASSOC);
		} catch ( PDOException $e ) {
			throw new RuntimeException('Query failed: ' . $e->getMessage());
		}
	}
	
	
	/**
	 * Execute query and returns bool if successful
	 *
	 * @param array|null $parametersOverride
	 *
	 * @return bool
	 */
	public function exec(?array $parametersOverride = null): bool
	{
		try {
			return $this->statement->execute($parametersOverride ?: $this->parameters);
		} catch ( PDOException $e ) {
			throw new RuntimeException('Query failed: ' . $e->getMessage());
		}
	}
}
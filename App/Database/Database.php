<?php

namespace Sperky\App\Database;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
	private static ?PDO $pdo = null;
	private static ?self $instance = null;
	private static ?array $config = null;
	
	
	private function __construct()
	{
		// Private constructor to prevent direct instantiation
	}
	
	
	/**
	 * Get Database instance
	 *
	 * @return self
	 */
	public static function getInstance(): self
	{
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	
	public static function getDbName(): string
	{
		$config = self::getConfig();
		return $config['database'];
	}
	
	
	public function getConnection(): PDO
	{
		if ( self::$pdo === null ) {
			$config = self::getConfig();
			$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $config['host'], $config['database']);
			try {
				self::$pdo = new PDO($dsn, $config['login'], $config['password']);
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			} catch ( PDOException $e ) {
				throw new RuntimeException('Database connection failed: ' . $e->getMessage());
			}
		}
		return self::$pdo;
	}
	
	
	private static function getConfig(): array
	{
		if ( self::$config === null ) {
			self::$config = require 'config.php';
		}
		return self::$config;
	}
}

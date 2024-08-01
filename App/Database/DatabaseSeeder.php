<?php

namespace Sperky\App\Database;

use PDO;
use Sperky\App\Models\Attribute;
use Sperky\App\Models\Product;

class DatabaseSeeder
{
	const int PRODUCT_COUNT = 10;
	protected PDO $pdo;
	
	protected const TABLES = [
		'product' => [
			'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
			'pid' => 'INT NOT NULL',
			'purchase_price_usd' => 'DECIMAL(10,2) NOT NULL',
			'rate_eur_usd' => 'DECIMAL(10,2) NOT NULL',
			'stock_quantity' => 'INT NOT NULL',
		
		],
		'product_attribute' => [
			'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
			'pid' => 'INT NOT NULL',
			'paid' => 'BOOLEAN NOT NULL DEFAULT(false)',
			'purchase_price_usd' => 'DECIMAL(10,2) NOT NULL',
			'rate_eur_usd' => 'DECIMAL(10,2) NOT NULL',
			'stock_quantity' => 'INT NOT NULL',
		],
	];
	
	
	public function __construct()
	{
		$this->pdo = Database::getInstance()->getConnection();
	}
	
	
	public function seed(): void
	{
		$this->drop();
		$this->seedTables();
		$this->seedProducts();
	}
	
	
	private function seedProducts(): void
	{
		$pids = [];
		for ( $i = 0; $i < self::PRODUCT_COUNT + 10; $i++ ) {
			do {
				$pid = rand(1, 30);
			} while ( in_array($pid, $pids) );
			$pids[] = $pid;
		}
		
		
		for ( $i = 0; $i < self::PRODUCT_COUNT; $i++ ) {
			$productData = [
				'pid' => $pids[ $i ],
				'purchase_price_usd' => rand(100, 99999) / 100,
				'rate_eur_usd' => rand(10, 200) / 100,
				'stock_quantity' => rand(10, 200)
			];
			Product::create($productData);
		}
		
		// Shuffle pids
		shuffle($pids);
		
		for ( $i = 0; $i < self::PRODUCT_COUNT; $i++ ) {
			$attributeData = [
				'pid' => $pids[ $i ],
				'paid' => rand(0, 1),
				'purchase_price_usd' => rand(100, 99999) / 100,
				'rate_eur_usd' => rand(10, 200) / 100,
				'stock_quantity' => rand(10, 200)
			];
			Attribute::create($attributeData);
		}
	}
	
	
	/**
	 * Drop all tables in database
	 *
	 * @return void
	 */
	private function drop(): void
	{
		// Get all table names
		$dbName = Database::getDbName();
		$tables = Query::create("
			SELECT table_name
			FROM INFORMATION_SCHEMA.TABLES
			WHERE table_type = 'BASE TABLE'
			AND table_schema = :database"
		)->getRows([':database' => $dbName]);
		
		// Drop them
		array_walk($tables, function ($table) {
			Query::create('DROP TABLE IF EXISTS ' . $table->table_name)->exec();
		});
	}
	
	
	/**
	 * Generate tables from self::TABLES
	 *
	 * @return void
	 */
	private function seedTables(): void
	{
		foreach ( self::TABLES as $table => $columns ) {
			// Construct the SQL for creating the table
			$columnsSql = [];
			foreach ( $columns as $column => $definition ) {
				$columnsSql[] = "`$column` $definition";
			}
			$columnsSql = implode(", ", $columnsSql);
			
			// Execute the query
			$query = "CREATE TABLE IF NOT EXISTS `$table` (\n$columnsSql\n)";
			Query::create($query)->exec();
		}
	}
	
	
}

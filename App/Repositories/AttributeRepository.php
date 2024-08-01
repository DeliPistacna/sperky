<?php

namespace Sperky\App\Repositories;

use InvalidArgumentException;
use PDO;
use Sperky\App\Database\Database;
use Sperky\App\Database\Query;

class AttributeRepository extends Repository
{
	
	
	public function create(array $attributeData): bool
	{
		
		return Query::create("INSERT INTO `product_attribute` (pid, paid, purchase_price_usd, rate_eur_usd, stock_quantity) values (:pid, :paid, :purchase_price_usd, :rate_eur_usd, :stock_quantity)")
			->exec($attributeData);
	}
}
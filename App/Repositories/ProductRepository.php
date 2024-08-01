<?php

namespace Sperky\App\Repositories;

use InvalidArgumentException;
use Sperky\App\Database\Query;

class ProductRepository extends Repository
{
	
	
	/**
	 * Get warehouse products with prioritizing product_attributes
	 *
	 * @return array|null
	 */
	public function getProductsAndAttributes(): ?array
	{
		return Query::create("
			SELECT
			    pid,
			    purchase_price_usd,
			    rate_eur_usd,
			    stock_quantity
			FROM
			    product
			WHERE
			    pid
			NOT IN (SELECT pid FROM product_attribute)
			UNION
			SELECT
			    pid,
			    purchase_price_usd,
			    rate_eur_usd,
			    stock_quantity
			FROM
			    product_attribute
			    ")
			->getRows();
	}
	
	
	public function create(array $productData): bool
	{
		return Query::create("INSERT INTO `product` (pid, purchase_price_usd, rate_eur_usd, stock_quantity) values (:pid, :purchase_price_usd, :rate_eur_usd, :stock_quantity)")
			->exec($productData);
	}
}
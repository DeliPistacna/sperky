<?php

namespace Sperky\App\Models;

use InvalidArgumentException;
use Sperky\App\Repositories\ProductRepository;

class Product extends Model
{
	
	public const array REQUIRED_KEYS = ['pid', 'purchase_price_usd', 'rate_eur_usd', 'stock_quantity'];
	
	/**
	 * Define repository for this model
	 *
	 * @return ProductRepository
	 */
	protected static function createRepository(): ProductRepository
	{
		return new ProductRepository();
	}
	
	
	/**
	 * Get current warehouse value in EUR
	 *
	 * @return float
	 */
	public static function getWarehouseValue(): float
	{
		$products = static::getRepository()->getProductsAndAttributes();
		
		if ( $products === null ) {
			return 0;
		}
		
		$result = 0;
		foreach ( $products as $product ) {
			$result += ( $product->purchase_price_usd / $product->rate_eur_usd ) * $product->stock_quantity;
		}
		return round($result, 2);
	}
	
	
	/**
	 * Create new product
	 *
	 * @param array $productData
	 *
	 * @return bool
	 */
	public static function create(array $productData): bool
	{
		static::validate($productData);
		return static::getRepository()->create($productData);
	}
}
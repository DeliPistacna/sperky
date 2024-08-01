<?php

namespace Sperky\App\Models;

use Sperky\App\Repositories\AttributeRepository;

class Attribute extends Model
{
	public const array REQUIRED_KEYS = ['pid', 'paid', 'purchase_price_usd', 'rate_eur_usd', 'stock_quantity'];
	
	
	protected static function createRepository(): AttributeRepository
	{
		return new AttributeRepository();
	}
	
	
	/**
	 * Create new product_attribute
	 *
	 * @param array $attributeData
	 *
	 * @return int
	 */
	public static function create(array $attributeData): int
	{
		static::validate($attributeData);
		return static::getRepository()->create($attributeData);
	}
}
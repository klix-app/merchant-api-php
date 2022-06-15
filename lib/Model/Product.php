<?php
namespace Klix\Model;

class Product implements \JsonSerializable {
	use JsonSerializer;
	
	/**
	 * @var string
	 */
	public $name;
	
	/**
	 * @var float
	 */
	public $quantity;
	
	/**
	 * @var int
	 */
	public $price;
	
	/**
	 * @var int
	 */
	public $discount;
	
	/**
	 * @var float
	 */
	public $tax_percent;
}

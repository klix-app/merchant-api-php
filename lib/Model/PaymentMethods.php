<?php
namespace Klix\Model;

class PaymentMethods implements \JsonSerializable {
	use JsonSerializer;

	/**
	 *
	 * @var string[]
	 */
	public $available_payment_methods;
	
	/**
	 *
	 * @var string[][]
	 */
	public $by_country;
	
	/**
	 *
	 * @var string[]
	 */
	public $country_names;
	
	/**
	 *
	 * @var string[]
	 */
	public $names;
	/**
	 *
	 * @var string[]
	 */
	public $logos;

	/**
	 *
	 * @var object
	 */
	public $payment_method_groups;

	/**
	 *
	 * @var string[]
	 */
	public $card_methods;
}


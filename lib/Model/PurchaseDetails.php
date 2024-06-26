<?php
namespace Klix\Model;

class PurchaseDetails implements \JsonSerializable {
	use JsonSerializer;

	/**
	 *
	 * @var string
	 */
	public $currency;
	
	/**
	 *
	 * @var Product[]
	 */
	public $products;

	/**
	 *
	 * @var PaymentMethodDetails
	 */
	public $payment_method_details;
	
	/**
	 *
	 * @var int
	 */
	public $total;
	
	/**
	 *
	 * @var string
	 */
	public $language;
	
	/**
	 *
	 * @var string
	 */
	public $notes;
	
	/**
	 *
	 * @var int
	 */
	public $debt;
	
	/**
	 *
	 * @var int
	 */
	public $subtotal_override;
	
	/**
	 *
	 * @var int
	 */
	public $total_tax_override;
	
	
	/**
	 *
	 * @var int
	 */
	public $total_discount_override;
	
	/**
	 *
	 * @var int
	 */
	public $total_override;
	
	/**
	 *
	 * @var string[]
	 */
	public $request_client_details;
	
	/**
	 *
	 * @var string
	 */
	public $timezone;
	
	/**
	 *
	 * @var bool
	 */
	public $due_strict;
	
	/**
	 *
	 * @var string
	 */
	public $email_message;
}


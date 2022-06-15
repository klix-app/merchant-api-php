<?php
namespace Klix\Model;

class PaymentDetails implements \JsonSerializable {
	use JsonSerializer;

	/**
	 *
	 * @var bool
	 */
	public $is_outgoing;
	
	/**
	 *
	 * @var string
	 */
	public $payment_type;
	
	/**
	 *
	 * @var int
	 */
	public $amount;
	
	/**
	 *
	 * @var string
	 */
	public $currency;
	
	/**
	 *
	 * @var int
	 */
	public $net_amount;
	
	/**
	 *
	 * @var int
	 */
	public $fee_amount;
	
	/**
	 *
	 * @var int
	 */
	public $pending_amount;
	
	/**
	 *
	 * @var int
	 */
	public $pending_unfreeze_on;
	
	/**
	 *
	 * @var string
	 */
	public $description;
	
	/**
	 *
	 * @var int
	 */
	public $paid_on;
	
	/**
	 *
	 * @var int
	 */
	public $remote_paid_on;
}

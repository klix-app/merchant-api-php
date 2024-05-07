<?php
namespace Klix\Model;

class PaymentMethodDetails implements \JsonSerializable {
	use JsonSerializer;
	
	/**
	 *
	 * @var PisBulkPurchase[]
	 */
	public $pis_bulk_purchase;
}


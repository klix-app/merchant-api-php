<?php
namespace Klix\Model;

class PisBulkPurchase implements \JsonSerializable {
	use JsonSerializer;

	/**
	 *
	 * @var string
	 */
	public $creditor_name;

	/**
	 *
	 * @var string
	 */
	public $creditor_iban;
}


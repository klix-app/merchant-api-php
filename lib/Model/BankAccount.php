<?php
namespace Klix\Model;

class BankAccount implements \JsonSerializable {
	use JsonSerializer;

	/**
	 *
	 * @var string
	 */
	public $bank_account;
	
	/**
	 *
	 * @var string
	 */
	public $bank_code;

}

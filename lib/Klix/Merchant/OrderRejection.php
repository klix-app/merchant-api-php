<?php

namespace Klix\Merchant;

class OrderRejection extends Model
{
	/**
	 * @return string
	 */
	public function getReasonCode()
	{
		return $this->values['reasonCode'];
	}

	/**
	 * @param string $reasonCode
	 * @return $this
	 */
	public function setReasonCode($reasonCode)
	{
		$this->values['reasonCode'] = $reasonCode;
		return $this;
	}

	/**
	 * @param $reasonCode string
	 */
	public function __construct($reasonCode)
	{
		parent::__construct(['reasonCode'=>$reasonCode]);
	}
}

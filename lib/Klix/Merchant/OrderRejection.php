<?php

namespace Klix\Merchant;

class OrderRejection extends Model
{
	/**
	 * @return string Order rejection reason code. Possible values: PRICE_CHANGED, PRODUCT_NOT_AVAILABLE,
	 * RESERVATION_EXPIRED, DELIVERY_ADDRESS_NOT_SUPPORTED, MERCHANT_RISK_TOO_HIGH, MERCHANT_MISCONFIGURATION,
	 * MERCHANT_NOT_AVAILABLE, OTHER
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

<?php

namespace Klix\Merchant;

class MerchantOrderVerificationRequest extends Model
{
	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return $this->values['orderId'];
	}

	/**
	 * @return string
	 */
	public function getExternalOrderId()
	{
		return $this->values['externalOrderId'];
	}
}

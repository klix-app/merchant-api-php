<?php

namespace Klix\Merchant;

class MerchantPurchaseFinalizedNotificationRequest extends Model
{
	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return new Customer($this->values['orderId']);
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return new Customer($this->values['status']);
	}
}

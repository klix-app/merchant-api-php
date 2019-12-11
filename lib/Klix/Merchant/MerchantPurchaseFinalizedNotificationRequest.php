<?php

namespace Klix\Merchant;

class MerchantPurchaseFinalizedNotificationRequest extends Model
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

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->values['status'];
	}

	/**
	 * @return string
	 */
	public function getErrorMessage()
	{
		return $this->values['errorMessage'];
	}

	/**
	 * @return string
	 */
	public function getErrorCode()
	{
		return $this->values['errorCode'];
	}

}

<?php

namespace Klix\Api;

class OrderRefundResponse extends Model
{
	/**
	 * @return float
	 */
	public function getTotalRefundedAmount()
	{
		return $this->values['totalRefundedAmount'];
	}

	/**
	 * @param float $totalRefundedAmount
	 * @return $this
	 */
	public function setTotalRefundedAmount($totalRefundedAmount)
	{
		$this->values['totalRefundedAmount'] = $totalRefundedAmount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getOrderEffectiveAmount()
	{
		return $this->values['orderEffectiveAmount'];
	}

	/**
	 * @param float $orderEffectiveAmount
	 * @return $this
	 */
	public function setOrderEffectiveAmount($orderEffectiveAmount)
	{
		$this->values['orderEffectiveAmount'] = $orderEffectiveAmount;
		return $this;
	}
}

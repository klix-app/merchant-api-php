<?php

namespace Klix\Api;

class OrderRefundRequest extends Model
{
	/**
	 * @param $orderId string
	 * @param $orderRefund OrderRefund
	 */
	public function __construct($orderId, $orderRefund)
	{
		$this->values['orderId'] = $orderId;
		$this->values['orderRefund'] = $orderRefund->values;
	}

	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return $this->values['orderId'];
	}

	/**
	 * @return OrderRefund
	 */
	public function getOrderRefund()
	{
		return new OrderRefund($this->values['orderRefund']);
	}
}

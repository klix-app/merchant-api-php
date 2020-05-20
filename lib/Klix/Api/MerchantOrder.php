<?php

namespace Klix\Api;

class MerchantOrder extends Model
{
	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->values['id'];
	}

	/**
	 * @param string $id
	 * @return $this
	 */
	public function setId($id)
	{
		$this->values['id'] = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return $this->values['order_id'];
	}

	/**
	 * @param string $orderId
	 * @return $this
	 */
	public function setOrderId($orderId)
	{
		$this->values['order_id'] = $orderId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->values['status'];
	}

	/**
	 * @param string $status
	 * @return $this
	 */
	public function setStatus($status)
	{
		$this->values['status'] = $status;
		return $this;
	}

	/**
	 * @return Company
	 */
	public function getCompany()
	{
		return new Company($this->values['company']);
	}

	/**
	 * @param Company $company
	 * @return $this
	 */
	public function setCompany($company)
	{
		$this->values['company'] = $company->values;
		return $this;
	}

	/**
	 * @return Customer
	 */
	public function getCustomer()
	{
		return new Customer($this->values['customer']);
	}

	/**
	 * @param Customer $customer
	 * @return $this
	 */
	public function setCustomer($customer)
	{
		$this->values['customer'] = $customer->values;
		return $this;
	}

	/**
	 * @return Payment
	 */
	public function getPayment()
	{
		return new Payment($this->values['payment']);
	}

	/**
	 * @param Payment $payment
	 * @return $this
	 */
	public function setPayment($payment)
	{
		$this->values['payment'] = $payment->values;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getTaxAmount()
	{
		return $this->values['tax_amount'];
	}

	/**
	 * @param float $taxAmount
	 * @return $this
	 */
	public function setTaxAmount($taxAmount)
	{
		$this->values['tax_amount'] = $taxAmount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getAmount()
	{
		return $this->values['amount'];
	}

	/**
	 * @param float $amount
	 * @return $this
	 */
	public function setAmount($amount)
	{
		$this->values['amount'] = $amount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getEffectiveAmount()
	{
		return $this->values['effective_amount'];
	}

	/**
	 * @param float $effectiveAmount
	 * @return $this
	 */
	public function setEffectiveAmount($effectiveAmount)
	{
		$this->values['effective_amount'] = $effectiveAmount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getTotalAmount()
	{
		return $this->values['total_amount'];
	}

	/**
	 * @param float $totalAmount
	 * @return $this
	 */
	public function setTotalAmount($totalAmount)
	{
		$this->values['total_amount'] = $totalAmount;
		return $this;
	}

	/**
	 * @return OrderItem[]
	 */
	public function getItems()
	{
		return array_map(function($orderLineValues) {
			return new OrderItem($orderLineValues);
		}, (array) $this->values['items']);
	}

	/**
	 * @param OrderItem[] $items
	 * @return $this
	 */
	public function setItems($items)
	{
		$this->values['items'] = array_map(function($orderItem) {
			return $orderItem->values;
		}, $items);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->values['currency'];
	}

	/**
	 * @param string $currency
	 * @return $this
	 */
	public function setCurrency($currency)
	{
		$this->values['currency'] = $currency;
		return $this;
	}

	/**
	 * @return MerchantUrls
	 */
	public function getMerchantUrls()
	{
		return new MerchantUrls($this->values['merchant_urls']);
	}

	/**
	 * @param MerchantUrls $merchantUrls
	 * @return $this
	 */
	public function setMerchantUrls($merchantUrls)
	{
		$this->values['merchant_urls'] = $merchantUrls->values;
		return $this;
	}

	/**
	 * @return Shipping
	 */
	public function getShipping()
	{
		return new Shipping($this->values['shipping']);
	}

	/**
	 * @param Shipping $shipping
	 * @return $this
	 */
	public function setShipping($shipping)
	{
		$this->values['shipping'] = $shipping->getValues();
		return $this;
	}
}

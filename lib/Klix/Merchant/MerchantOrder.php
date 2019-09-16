<?php

namespace Klix\Merchant;

class MerchantOrder extends Model
{

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
	 * @return float
	 */
	public function getOrderAmount()
	{
		return $this->values['order_amount'];
	}

	/**
	 * @param float $orderAmount
	 * @return $this
	 */
	public function setOrderAmount($orderAmount)
	{
		$this->values['order_amount'] = $orderAmount;
		return $this;
	}

	/**
	 * @return OrderItem[]
	 */
	public function getOrderLines()
	{
		return array_map(function($orderLineValues) {
			return new OrderItem($orderLineValues);
		}, (array) $this->values['order_lines']);
	}

	/**
	 * @param OrderItem[] $orderLines
	 * @return $this
	 */
	public function setOrderLines($orderLines)
	{
		$this->values['order_lines'] = array_map(function($orderItem) {
			return $orderItem->values;
		}, $orderLines);
		return $this;
	}

	/**
	 * @return float
	 */
	public function getOrderTaxAmount()
	{
		return $this->values['order_tax_amount'];
	}

	/**
	 * @param float $orderTaxAmount
	 * @return $this
	 */
	public function setOrderTaxAmount($orderTaxAmount)
	{
		$this->values['order_tax_amount'] = $orderTaxAmount;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPurchaseCurrency()
	{
		return $this->values['purchase_currency'];
	}

	/**
	 * @param string $purchaseCurrency
	 * @return $this
	 */
	public function setPurchaseCurrency($purchaseCurrency)
	{
		$this->values['purchase_currency'] = $purchaseCurrency;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMerchantReference()
	{
		return $this->values['merchantReference'];
	}

	/**
	 * @param string $merchantReference
	 * @return $this
	 */
	public function setMerchantReference($merchantReference)
	{
		$this->values['merchantReference'] = $merchantReference;
		return $this;
	}

	/**
	 * @return Shipment
	 */
	public function getShipment()
	{
		return new Shipment($this->values['shipment']);
	}

	/**
	 * @param Shipment $shipment
	 * @return $this
	 */
	public function setShipment($shipment)
	{
		$this->values['shipment'] = $shipment->getValues();
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
}
